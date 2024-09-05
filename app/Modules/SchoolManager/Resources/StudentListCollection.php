<?php

namespace App\Modules\SchoolManager\Resources;

use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Ramsey\Collection\Collection as CollectionCollection;

class StudentListCollection extends BaseResource
{
   
    public function __construct(public Collection|SupportCollection|CollectionCollection|array $items, public bool $more_student_info = false){
        parent::__construct($items);
    }
    
    public function toArray($request)
    {
       return $this->items->map( fn($item) => ( new StudentListResource( $item, $this->more_student_info ) ) );
    }
}
