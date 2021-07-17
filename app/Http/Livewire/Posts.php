<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class Posts extends Component
{

    public $posts, $title, $body, $post_id;
    public $isOpen = 0;

    public function render()
    {
        $this->posts = Post::all();
        return view('livewire.posts');
    }
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }
    public function openModal()
    {
        $this->isOpen = true;
    }
    public function closeModal()
    {
        $this->isOpen = false;
    }
    public function resetInputFields()
    {
        $this->title = '';
        $this->body = '';
        $this->post_id = '';
    }
    public function store()
    {
        $this->validate([
            'title' => 'required',
            'body' => 'required',
        ]);        
        Post::updateOrCreate(['id' => $this->post_id],[
            'title' => $this->title,
            'body' => $this->body
        ]);        
        session()->flash('message', 
            $this->post_id ? 'Postagem atualizada com sucesso' : 'Postagem criada com sucesso');
        $this->closeModal();
        $this->resetInputFields();
        }
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->post_id = $id;
        $this->title = $post->title;
        $this->body = $post->body;

        $this->openModal();
    }
    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Postagem deletada com sucesso');
    }
    }
