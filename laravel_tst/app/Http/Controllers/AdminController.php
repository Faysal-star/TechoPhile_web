<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Report;
use App\Facades\CustomAuth;
use App\Models\chatRoom;
use App\Models\Hiring;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ReportNotification;

class AdminController extends Controller
{
    
    public function admin(){
        // return view('admin.reports') ;
        return redirect('admin/reports');
    }

    public function adminReports(){
        $allReports = Report::all() ;

        $reports = [] ;

        foreach($allReports as $report){
            $reports[] = [
                'post_id' => $report->post->id,
                'post' => $report->post->title,
                'user' => $report->user->name,
                'reason' => $report->reportBody,
                'count' => $report->post->reports->count(),
                'created_at' => $report->created_at
            ] ;
        }

        // dd($reports) ;

        return view('admin.reports' , [
            'reports' => $reports
        ]) ;
    }

    public function adminDelete(Post $post){
        if(CustomAuth::user()->type != 'admin'){
            return redirect('home') ;
        }

        $reportNotifyAttributes = [
            'user_id' => $post->user->id,
            'title' => $post->title
        ] ;

        ReportNotification::create($reportNotifyAttributes) ;

        $post->delete() ;

        return redirect('admin/reports') ;
    }

    public function adminRooms(){
        $rooms = chatRoom::all() ;
        // dd($rooms) ;
        return view('admin.rooms', [
            'rooms' => $rooms
        ]) ;
    }

    public function adminRoomDelete(chatRoom $room){
        $room->delete() ;
        return redirect('admin/rooms') ;
    }

    public function addRoom(Request $request){

        // dd($request->all()) ;
        $attributes = $request->validate([
            'room_name' => 'required'
        ]) ;


        chatRoom::create($attributes) ;

        return redirect('admin/rooms') ;
    }

    public function hiring(){
        // dd(CustomAuth::user()->type) ;
        if(CustomAuth::user()->type != 'superAdmin'){
            return redirect('admin/reports') ;
        }
        $hirings = Hiring::all() ;
        $jobs = [] ;

        foreach($hirings as $hiring){
            $jobs[] = [
                'id' => $hiring->id,
                'user_id' => $hiring->user_id,
                'profile' => User::find($hiring->user_id)->profile->id,
                'user' => User::find($hiring->user_id)->name,
                'msg' => $hiring->msg,
                'created_at' => $hiring->created_at
            ] ;
        }
        // Existing admins
        $admins = User::where('type', 1)->get() ;

        // dd($jobs) ;

        return view('admin.hiring' , [
            'jobs' => $jobs,
            'admins' => $admins
        ]) ;
    }

    public function adminHiringReject(Hiring $hiring){
        if(CustomAuth::user()->type != 'superAdmin'){
            return redirect('admin/reports') ;
        }
        $hiring->delete() ;
        return redirect('admin/hiring') ;
    }

    public function adminHiringAccept(Hiring $hiring){
        if(CustomAuth::user()->type != 'superAdmin'){
            return redirect('admin/reports') ;
        }
        $user = User::find($hiring->user_id) ;
        $user->type = 1 ;
        $user->save() ;

        $hiring->delete() ;

        return redirect('admin/hiring') ;
    }

    public function adminApply(){
        return view('admin.apply') ;
    }

    public function adminApplyStore(Request $request){
        $attributes = $request->validate([
            'msg' => 'required'
        ]) ;

        $attributes['user_id'] = CustomAuth::user()->id ;

        Hiring::create($attributes) ;

        return redirect('profile/' . CustomAuth::user()->profile->id);
    }

    public function adminRemove(User $user){
        if(CustomAuth::user()->type != 'superAdmin'){
            return redirect('admin/reports') ;
        }

        $user->type = 0 ;
        $user->save() ;
        // dd($user) ;
        return redirect('admin/apply') ;
    }
}
