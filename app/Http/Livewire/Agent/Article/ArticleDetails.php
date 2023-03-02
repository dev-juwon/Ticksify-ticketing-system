<?php

namespace App\Http\Livewire\Agent\Article;

use App\Models\Article;
use App\Models\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ArticleDetails extends Component
{
    use WithFileUploads;

    public Article $article;
    public $showSettings = false;
    public $showImageModal = false;
    public $image;
    public $imageUrl;
    public $selectedImage;

    protected $listeners = [
        'openImageModal',
    ];

    protected $rules = [
        'article.collection_id' => 'nullable|exists:collections,id',
        'article.title' => 'required|string|max:255',
        'article.slug' => 'nullable|string|max:255',
        'article.excerpt' => 'nullable|string|max:255',
        'article.content' => 'required|string',
        'article.seo_title' => 'nullable|string',
        'article.seo_description' => 'nullable|string',
    ];

    public function updatedArticleTitle($value)
    {
        $this->article->title = empty($value) ? trans('Untitled article') : $value;
    }

    public function updatedArticleSlug($value)
    {
        $this->article->slug = empty($value) ? \Str::slug($this->article->title) : \Str::slug($value);
    }

    public function openImageModal()
    {
        $this->showImageModal = true;
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function updatedImage()
    {
        $this->validate([
            'image' => 'required|image|max:1024',
        ]);

        $this->uploadImageFromFile();
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function uploadImageFromFile()
    {
        $this->article->addMedia($this->image->getRealPath())
            ->usingFileName($this->image->hashName())
            ->toMediaCollection('images');

        $this->article->load(['media' => function ($query) {
            return $query->latest();
        }]);

        $this->reset('image');

        $this->dispatchBrowserEvent('upload-image-success', ['imageId' => $this->article->getMedia('images')->last()->id]);
    }

    /**
     * @throws FileCannotBeAdded
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function uploadImageFromURL()
    {
        $this->validate([
            'imageUrl' => 'required|url',
        ]);

        $this->article->addMediaFromUrl($this->imageUrl)
            ->toMediaCollection('images');

        $this->article->load(['media' => function ($query) {
            return $query->latest();
        }]);

        $this->reset('imageUrl');

        $this->dispatchBrowserEvent('upload-image-success', ['imageId' => $this->article->getMedia('images')->last()->id]);
    }

    public function insertImage(Media $image)
    {
        $this->dispatchBrowserEvent('tiptap-insert-image', ['name' => $image->name, 'url' => $image->getFullUrl()]);

        $this->showImageModal = false;
    }

    public function deleteImage(Media $image)
    {
        $image->delete();

        $this->article->load(['media' => function ($query) {
            return $query->latest();
        }]);
    }

    public function save()
    {
        $this->validate();

        $this->article->save();

        $this->notify(trans('Article has been updated.'));
    }

    public function delete()
    {
        $this->article->delete();
        $this->redirect(route('agent.articles.list'));
    }

    public function getCollectionsProperty()
    {
        return Collection::all();
    }

    public function render()
    {
        return view('livewire.agent.article.article-details');
    }
}
