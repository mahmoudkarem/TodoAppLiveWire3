<?php

namespace App\Livewire;
use App\Models\Todo;
use Livewire\Attributes\Rule;

use Livewire\Component;
use Livewire\withpagination;

class TodoList extends Component
{

    use withpagination;
    public $name ;
    public $search;

    public $EditTodoId;
    public $EditTodoName;

    public function edit($todoId){
        $this->EditTodoId = $todoId;
        $this->EditTodoName  = Todo::find($todoId)->name;
        

    } 

    public function create(){
       //validate

        $validated = $this->validate([ 
            'name' => 'required|min:3',
        ]);
 
        Todo::create($validated);
        //create todo
        //clear the input
        $this->reset('name');
        //send flush message
        session()->flash('success','To do Added Success');

        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.todo-list',[
            'todos'=> Todo::latest()->where('name','like',"%{$this->search}%")->paginate(3),
        ]);
    }


    public function delete($todoId){
        try{
           Todo::findOrfail($todoId)->delete();
        }
        catch (Exception $e){
            session()->flash('error_delete','Failed To Delete Todo');
            return;
        }
    }

    public function toggle ($todoId){    
        $todo = Todo::find($todoId);
        $todo->completed = !$todo->completed;
        $todo->save();

    }

    public function cancelEdit(){
        $this->reset('EditTodoId','EditTodoName');
    }

    public function update(){
        $validated = $this->validate([ 
            'EditTodoName' => 'required|min:3',
        ]);
        Todo::find($this->EditTodoId)->update([
            'name' => $this->EditTodoName
        ]);
        
        $this->cancelEdit();
    }
}
