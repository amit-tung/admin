<?php

namespace App\Http\Controllers\adminpanel;

use App\Http\Controllers\Controller;
use Revolution\Google\Sheets\Facades\Sheets;
use Illuminate\Http\Request;
use App\Models\Article ;
use App\Models\Project;


class DashboardController extends Controller
{
    
    public function index()
    {
        return view('adminpanel.dashboard');

        $category = Article::select('category')->app($account_id)->category()->get();
        $article = Article::app($account_id)->orderBy('view_counts')->take(5)->get();
        return view('index',compact('category','article','account_id'));
    }

    public function create()
    {
    
        return view('project-create');

    }
    public function store(Request $request)
    {

        $input = $request->input();
        $input['user_id'] = auth()->id();
        $project = Project::create($input);
        if(!$project)
        {
            return "err";
        }

        $url = str_replace("https://docs.google.com/spreadsheets/d/","",$request->google_sheet_url);
        $sheetId = explode('/',$url);
        $sheets = Sheets::spreadsheet($sheetId[0])
        ->sheet('Articles')
        ->get();

        $header = $sheets[0];
        unset($sheets[0]);
        $posts = Sheets::collection($header, $sheets);
        // return $posts[1]['No.'];
        foreach ($posts as $key => $row) {
            
            $create['page_id']= $row['Page ID'];
            $create['no']= $row['No.'];
            $create['title']= $row['Title'];
            $create['category']= $row['Category'];
            $create['sub_category']= $row['Sub category'];
            $create['text']= $row['Text'];
            $create['search_assist_word']= $row['Search assist word'];
            $create['number_of_accesses_pv']= $row['Number of accesses (PV)'];
            $create['number_of_accesses_sessions']= $row['Number of accesses (sessions)'];
            $create['number_of_resolved']= $row['Number of resolved'];
            $create['number_of_unresolved']= $row['Number of Unresolved'];
            $create['web_link']= $row['Web Link'];
            $create['status']= $row['status'];
            $create['user_id']= auth()->id();
            $create['last_updated']= $row['Last updated'];
            $create['last_renewal']= $row['Last renewer'];
            $create['project_id']= $project->id;
            Article::create($create);
        }

        return redirect()->route('project.index');
    }

    public function syncO()
    {

        $input['user_id'] = auth()->id();
        $project = Project::find($id);
        if(!$project)
        {
            return "err";
        }

        $sheets = Sheets::spreadsheet($project->google_sheet_url)
        ->sheet('Articles')
        ->get();

        $header = $sheets[0];
        unset($sheets[0]);
        $posts = Sheets::collection($header, $sheets);
        $article = Article::where('project_id',$project->id)->get();
        if ($article->count()>0) {            
            $i=0;
            foreach ($posts as $key => $row) {
                $update['page_id']= $row['Page ID'];
                $update['no']= $row['No.'];
                $update['title']= $row['Title'];
                $update['category']= $row['Category'];
                $update['sub_category']= $row['Sub category'];
                $update['text']= $row['Text'];
                $update['search_assist_word']= $row['Search assist word'];
                $update['number_of_accesses_pv']= $row['Number of accesses (PV)'];
                $update['number_of_accesses_sessions']= $row['Number of accesses (sessions)'];
                $update['number_of_resolved']= $row['Number of resolved'];
                $update['number_of_unresolved']= $row['Number of Unresolved'];
                $update['web_link']= $row['Web Link'];
                $update['status']= $row['status'];
                $update['last_updated']= $row['Last updated'];
                $update['last_renewal']= $row['Last renewer'];
                $article[$i]->update($update);
                $i++;
            }
        }
        else
        {
            foreach ($posts as $key => $row) {
            
                $create['page_id']= $row['Page ID'];
                $create['no']= $row['No.'];
                $create['title']= $row['Title'];
                $create['category']= $row['Category'];
                $create['sub_category']= $row['Sub category'];
                $create['text']= $row['Text'];
                $create['search_assist_word']= $row['Search assist word'];
                $create['number_of_accesses_pv']= $row['Number of accesses (PV)'];
                $create['number_of_accesses_sessions']= $row['Number of accesses (sessions)'];
                $create['number_of_resolved']= $row['Number of resolved'];
                $create['number_of_unresolved']= $row['Number of Unresolved'];
                $create['web_link']= $row['Web Link'];
                $create['status']= $row['status'];
                $create['user_id']= auth()->id();
                $create['last_updated']= $row['Last updated'];
                $create['last_renewal']= $row['Last renewer'];
                $create['project_id']= $project->id;
                Article::create($create);
            }
      
        }

        return redirect()->route('project.view',$project->id);
    }
    public function sync()
    {
        
        $input['user_id'] = auth()->id();

        $sheets = Sheets::spreadsheet(auth()->user()->google_sheet_id)
        ->sheet('Articles')
        ->get();

        $header = $sheets[0];
        unset($sheets[0]);
        $posts = Sheets::collection($header, $sheets);
        foreach ($posts as $key => $row) {
            $update['page_id']= $row['Page ID'];
            $update['no']= $row['No.'];
            $update['title']= $row['Title'];
            $update['category']= $row['Category'];
            $update['sub_category']= $row['Sub category'];
            $update['text']= $row['Text'];
            $update['search_assist_word']= $row['Search assist word'];
            $update['number_of_accesses_pv']= $row['Number of accesses (PV)'];
            $update['number_of_accesses_sessions']= $row['Number of accesses (sessions)'];
            $update['number_of_resolved']= $row['Number of resolved'];
            $update['number_of_unresolved']= $row['Number of Unresolved'];
            $update['web_link']= $row['Web Link'];
            $update['status']= $row['status'];
            $update['last_updated']= $row['Last updated'];
            $update['last_renewal']= $row['Last renewer'];

            Article::updateOrCreate(
                ['page_id'=>$row['Page ID']],
                $update
            );
        }

        return "done";
        // return redirect()->route('project.view',$project->id);
    }

    public function articles()
    {
        $article = Article::query()->orderBy('no')->get();
        return view('article',compact('article'));
    }
    public function articleView($id)
    {
        $article = Article::query()->where('id',$id)->first();

        return view('view',compact('article'));
    }
}
