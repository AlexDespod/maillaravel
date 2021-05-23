<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomeActionPost;
use App\Models\BankModel;
use App\Models\User;
use App\Repositories\HomeActionsRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HomeActionsRepo $repo)
    {

        $user = request()->user();
        if (!$user) {
            return view('forguests');
        }

        $orders = null;

        $defaultValues = $repo->get_default_values_to_form();

        $inputs = request()->all();

        if ($inputs) {

            $validator = Validator::make($inputs, $repo->rules_for_index);
            if ($validator->fails()) {
                $errors    = $validator->getMessageBag();
                $view_data = array_merge(["inputs" => $inputs], $defaultValues);

                return view('home', $view_data)
                    ->with([
                        "errors"   => $errors,
                        "endpoint" => $inputs['endpoint'],
                        "column"   => $inputs['order_by'],
                    ]);

            }
            $orders = $repo->search_by_inputs($inputs, $user->isAdmin());

            $view_data = array_merge(["orders" => $orders, "inputs" => $inputs], $defaultValues);

            return view('home', $view_data)
                ->with([
                    "endpoint" => $inputs['endpoint'],
                    "column"   => $inputs['order_by'],
                ]);

        }

        $orders = $repo->get_all($user->isAdmin(), $user->name);

        $view_data = array_merge(["orders" => $orders], $defaultValues);

        return view('home', $view_data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('createpage');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeActionPost $request, HomeActionsRepo $repo)
    {

        $effected = $repo->splitInputs($request->validated());
        $stored   = $repo->store($effected);
        if (is_numeric($stored)) {
            return back()->with(["success_for_temp" => ["message" => "inserted with id :" . $stored]]);
        } else {
            return back()->with(["error_for_store" => ["message" => $stored->getMessage()]]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id, HomeActionsRepo $repo)
    {
        $this->authorize('view', BankModel::class);

        $record = $repo->show_one($id);
        if ($record) {
            // dd($record);
            return view('show', compact('record'));
        }
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, HomeActionsRepo $repo)
    {
        $order = $repo->get_for_edit($id);
        if ($order) {
            return view("edit", compact('order'));
        }
        abort(404);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HomeActionPost $request, $id, HomeActionsRepo $repo)
    {
        $this->authorize('update', BankModel::class);
        $effected = $repo->splitInputs($request->validated());
        $updated  = $repo->update($id, $effected);
        if (is_numeric($updated)) {
            return back()->with(["success_for_edit" => ["message" => "updated!!!"]]);
        }
        return back()->with(["error_for_edit" => ["message" => $updated->getMessage()]]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, HomeActionsRepo $repo)
    {
        $this->authorize('delete', BankModel::class);
        $destroyed = $repo->destroy($id);
        if (is_numeric($destroyed)) {
            return back()->with(["success_for_desrtoy" => ["message" => "deleted!!!"]]);
        }
        return back()->with(["error_for_destroy" => ["message" => $destroyed->getMessage()]]);

    }

}
