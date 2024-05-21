<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Report;
use App\Facades\CustomAuth;
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

}
