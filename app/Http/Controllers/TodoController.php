<?php
namespace App\Http\Controllers;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'all');
        return Inertia::render('Todo/index', [
          'todos' => Todo::lists($type),
          'left'=>Todo::left(),
          'type'=>$type,
        ]);
    }

    // 新增
    public function store(Request $request){
        Todo::create($request->validate([
            'title' => ['required', 'max:255'],
        ]));
        return $this->index($request);  
    }

    // 更新

    public function upd(Request $request){
        $row = $request->get('editedTodo', []);
        if($row){
            $upd = Arr::only($row, ['title', 'completed']);
            Todo::where('id', $row['id'])->update($upd);
        }
        return $this->index($request);
    }

    public function delete(Request $request){
        Todo::destroy($request->get('id', 0));
        return $this->index($request);
    }

    public function deleteComplete(Request $request){
        Todo::where('completed', 1)->delete();
        return $this->index($request);
    }

    public function allComplete(Request $request){
        Todo::where('id', '>', 0)->update(['completed'=>$request->get('completed', 0)]);
        return $this->index($request);
    }
}