<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class Upload extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $file = new \App\Models\File;
		$images = (!empty($this->config['files'])) ? $file->withFiles($this->config['files'])->get() : [];

        return view('widgets.upload', [
            'config'   => $this->config['config'],
            'name'     => $this->config['name'],
			'multiple' => $this->config['multiple'],
            'images'   => $images,
            'files'    => $this->config['files']
        ]);
    }
}
