from flask import Flask, request, jsonify

app = Flask(__name__)

users = []


@app.route('/user/<id>')
def get_user(id):
    user = {
        'id': id,
        'name': 'John Doe',
        'age': 29
    }

    extra = request.args.get('extra')
    if extra:
        user['extra'] = extra

    return jsonify(user) , 200

@app.route('/users')
def get_users():
    return jsonify(users), 200

@app.route('/create-user', methods=['POST'])
def create_user():
    data = request.get_json()

    user_len = len(users)

    user = {
        'id': user_len + 1,
        'name': data['name'],
        'age': data['age']
    }

    users.append(user)

    return jsonify(user), 201


@app.route('/upload', methods=['POST'])
def upload_file():
    if 'file' not in request.files:
        return 'No file part'
    
    file = request.files['file']
    
    if file.filename == '':
        return 'No selected file'
    
    try:
        file.save('uploads/' + file.filename)
        return 'File uploaded successfully'
    except Exception as e:
        return 'Error saving file: {}'.format(e)

if __name__ == "__main__":
    app.run(debug=True)