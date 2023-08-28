<div>

<div class="container content py-6 mx-auto">
@if(session("error_delete"))
    <div role="alert">
  <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
    Danger
  </div>
  <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
    <p>Something not ideal might be happening.</p>
  </div>
</div>
    @endif
        @include('livewire.includes.create-todo-list')
        @include('livewire.includes.search-box')
        </div>

       
        <div id="todos-list">
            @foreach($todos as $todo)
            @include('livewire.includes.todo-card')
            @endforeach

            <div class="my-2">
                {{$todos->links()}}
            </div>
        </div>
</div>
