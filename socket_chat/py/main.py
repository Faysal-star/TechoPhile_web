# import streamlit as st
from PyPDF2 import PdfReader
from langchain.text_splitter import RecursiveCharacterTextSplitter
import os
from langchain_google_genai import GoogleGenerativeAIEmbeddings
import google.generativeai as genai
from langchain_community.vectorstores import FAISS
from langchain_google_genai import ChatGoogleGenerativeAI
from langchain.chains.question_answering import load_qa_chain
from langchain.prompts import PromptTemplate
from dotenv import load_dotenv
from flask import Flask, request, jsonify
from flask_cors import CORS

load_dotenv()

app = Flask(__name__)
CORS(app)

index_name = "faiss_index"

genai.configure(api_key=os.getenv("GOOGLE_API_KEY"))

def get_pdf_text(pdf_docs):
    text = ""
    for pdf in pdf_docs:
        pdf_reader = PdfReader(pdf)
        for page in pdf_reader.pages:
            text += page.extract_text()

    return text

def get_text_chunks(text):
    text_splitter = RecursiveCharacterTextSplitter(chunk_size=10000 , chunk_overlap=1000)
    chunks = text_splitter.split_text(text) 
    return chunks

def get_vector_store(chunks , index_name):
    embeddings = GoogleGenerativeAIEmbeddings(model="models/embedding-001")
    vector_store = FAISS.from_texts(chunks , embedding=embeddings)
    vector_store.save_local(index_name)


def get_conversational_chain():

    prompt_template = """
    Answer the question as detailed as possible from the provided context, make sure to provide all the details, if the answer is not in
    provided context then say "The provided context does not mention anything about this". Don't give wrong answer.\n\n
    Context:\n {context}?\n
    Question: \n{question}\n

    Answer:
    """

    model = ChatGoogleGenerativeAI(model="gemini-pro",
                             temperature=0.5)

    prompt = PromptTemplate(template = prompt_template, input_variables = ["context", "question"])
    chain = load_qa_chain(model, chain_type="stuff", prompt=prompt)

    return chain



def user_input(user_question):
    embeddings = GoogleGenerativeAIEmbeddings(model = "models/embedding-001")
    
    new_db = FAISS.load_local( index_name , embeddings , allow_dangerous_deserialization=True)
    docs = new_db.similarity_search(user_question)

    chain = get_conversational_chain()

    
    response = chain(
        {"input_documents":docs, "question": user_question}
        , return_only_outputs=True)

    # print(docs)
    print(response)
    return response["output_text"]
    # st.write("Reply: ", response["output_text"])


def gen_res(pdf_docs , index_name):
    print(pdf_docs)
    try:
        raw_text = get_pdf_text([pdf_docs])
        text_chunks = get_text_chunks(raw_text)
        get_vector_store(text_chunks , index_name)
    except Exception as e:
        print(e)
    # with st.sidebar:
    #     st.title("Menu:")
    #     pdf_docs = st.file_uploader("Upload your PDF Files and Click on the Submit & Process Button", accept_multiple_files=True)
    #     if st.button("Submit & Process"):
    #         with st.spinner("Processing..."):
    #             raw_text = get_pdf_text(pdf_docs)
    #             text_chunks = get_text_chunks(raw_text)
    #             get_vector_store(text_chunks)
    #             st.success("Done")





@app.route('/upload', methods=['POST'])
def upload_file():
    if 'file' not in request.files:
        return 'No file part'
    
    file = request.files['file']
    
    if file.filename == '':
        return 'No selected file'
    
    try:
        file.save('uploads/' + file.filename)
        gen_res('uploads/' + file.filename , index_name)
        return jsonify({'data' : 'File uploaded successfully'}) , 200
    except Exception as e:
        return 'Error saving file: {}'.format(e)


@app.route('/get_question', methods=['POST'])
def get_question():
    data = request.get_json()
    response = user_input(data['question'])
    return jsonify(response), 200


@app.route('/get_general_question' , methods=['POST'])
def get_general_question():
    data = request.get_json()
    question = data['question']
    prompt = "Answer the question in short. Provide correct info as much as possible. \n\nQuestion: " + question + "\n\nAnswer: "
    llm = ChatGoogleGenerativeAI(model="gemini-pro")
    result = llm.invoke(prompt)
    print(result.content)
    response = result.content
    return jsonify(response), 200


# def main():
#     embeddings = GoogleGenerativeAIEmbeddings(model = "models/embedding-001")
    
#     new_db = FAISS.load_local("faiss_index", embeddings , allow_dangerous_deserialization=True)
#     docs = new_db.similarity_search("Final Round")

#     print(docs)

if __name__ == "__main__":
    app.run(debug=True)
    # main()
