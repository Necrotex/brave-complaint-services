<?php

class ComplaintsController extends BaseController {

    public function overviewView(){
        $view = $this->_defaultView()
            ->nest('content', 'complaints/overview');

        if(Auth::user()->isReviewer()){

            $permissions = Auth::user()->getPermissions();
            $types = Types::getTypesFromPermission($permissions);

            if(Auth::user()->canReview('all'))
            {
                $complaints = Complaint::orderBy('updated_at', 'desc')->get();
            }
            else
            {
                $query_types = array_keys($types);
                $complaints = Complaint::whereIn('type', $query_types)->orderBy('updated_at', 'desc')->get();
            }

            View::share('types', $types);


            $view = $view->nest('filter', 'parts/filter');
        } else {
            $complaints = Complaint::where('user_id', '=', Auth::user()->id)->orderBy('updated_at', 'desc')->get();
        }

        View::share('complaints', $complaints);

        return $view;
    }

    public function filterOverviewAction(){

        $view = $this->_defaultView()
            ->nest('content', 'complaints/overview');

        if(Auth::user()->isReviewer() && Auth::user()->canReview(Input::get('filter_type'))){

            $permisions = Auth::user()->getPermissions();
            $types = Types::getTypesFromPermission($permisions);

            if(!array_key_exists(Input::get('filter_type'), $types)){
                return Redirect::route('error')->with('flash_error', 'Not allowed!');
            }

            $complaints = Complaint::status(Input::get('filter_status'))
                ->type(Input::get('filter_type'))
                ->name(Input::get('filter_search_name'))
                ->orderBy('updated_at', 'desc');

            $view = $view->nest('filter', 'parts/filter');
        } else {
            $complaints = Complaint::where('user_id', '=', Auth::user()->id);
        }

        $complaints = $complaints->get();

        $selected = array(
            'status' => Input::get('filter_status'),
            'type'  => Input::get('filter_type'),
            'search' => Input::get('filter_search_name'),
        );

        View::share('types', $types);
        View::share('complaints', $complaints);
        View::share('selected', $selected);

        return $view;
    }
}