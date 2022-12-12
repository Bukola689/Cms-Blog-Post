<?php 

namespace App\Repositories\Tag;

use App\Models\Tag;

interface ITagRepository
{
    public function allTag();

    public function storeTag(array $data);

    public function getSingleTag(Tag $tag);

    public function updateTag(Tag $tag, array $data);

    public function deleteTag(Tag $tag);
}