<?php
namespace App\Services;

use DOMDocument;

class ArrayToHTML {

    protected $parent;
    protected $process;

    public function  __construct() {
        $this->process = new DOMDocument();
    }

    public function rootTag($parent, $attributes = [])
    {
        $this->parent = $this->process->createElement($parent);

        if( ! empty( $attributes ) ){

            foreach ($attributes as $key => $value) {
                $this->parent->setAttribute($key, $value);
            }

       }
    }

    public function appendToRootTag($tagName, $content = null, $attributes = [])
    {
        $child = $this->process->createElement($tagName, $content);

        if( ! empty( $attributes ) ){

            foreach ($attributes as $key => $value) {
                $child->setAttribute($key, $value);
            }

        }

        $this->parent->appendChild( $child );
    }

    public function appendToElement($sibling, $tagName, $content = null, $key = 0, $attributes = [])
    {
       $sibling =  $this->parent->getElementsByTagName($sibling)->item($key);

       $child = $this->process->createElement($tagName, $content);

       if( ! empty( $attributes ) ){

            foreach ($attributes as $key => $value) {
                $child->setAttribute($key, $value);
            }

       }

       $sibling->appendChild( $child );
    }

    public function getElementsByTagName($tag)
    {
       $sibling =  $this->parent->getElementsByTagName($tag);

       dd($sibling);

    }

    public function getContent() {
        return $this->process->saveHTML($this->parent);
    }
}
