<?php

namespace App;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use Auth;

class Upload
{
    protected $hash = [];
    protected $config;
    protected $extension;
	protected $clientMimeType;
    protected $clientOriginalName;
    protected $realPath;

    public function __construct($file, $config)
	{
        $this->config = array_merge(config('upload.' . $config), ['name' => $config]);
        $this->size = $file->getClientSize();
		$this->extension = $file->extension(); // 真实文件扩展名
		$this->clientMimeType = $file->getClientMimeType();
        $this->clientOriginalName = $file->getClientOriginalName();
		$this->realPath = $file->getRealPath();
    }

    // 获取文件的哈希散列值
    public function hash($type = 'sha1')
	{
        if (!isset($this->hash[$type])) {
            $this->hash[$type] = hash_file($type, $this->realPath);
        }

        return $this->hash[$type];
    }

    // 获取保存文件名
    protected function buildSaveName($name, $rule = 'date')
    {
		// 自动生成文件名
        if (true === $name) {
			if ($rule === 'date') {
				$name = date('Ymd') . '/' . md5(str_random(40));
			} else {
				if (in_array($rule, hash_algos())) {
					$hash = $this->hash($rule);
					$name = substr($hash, 0, 2) . '/' . substr($hash, 2);
				} else if (is_callable($rule)) {
					$name = call_user_func($rule);
				}
			}
        }

        if (!strpos($name, '.')) {
            $name .= '.' . $this->extension;
        }

        if (isset($this->config['save_path']) && !empty($this->config['save_path'])) {
            return $this->config['save_path'] . '/' . $name;
        }
 
        return $name;
    }

    public function checkExtension()
    {
        $ext = $this->config['ext'];
        if (is_string($ext)) {
            $ext = explode(',', $ext);
        }

        return in_array($this->extension, $ext);
    }

    public function checkSize() {
        return $this->size <= $this->config['size'];
    }

	public function save($saveName = true) {

        $saveName = $this->buildSaveName($saveName, $this->config['rule']);
		
        $file = new File(); // 保存文件数据记录
        $fileInfo = $file->where('sha1', $this->hash())->where('config', $this->config['name'])->first();
        if (!$fileInfo) {
            Storage::disk($this->config['disk'])->put($saveName, file_get_contents($this->realPath));
            $fileInfo = ['user_id' => Auth::id(), 'disk' => $this->config['disk'], 'name' => $this->clientOriginalName, 'savename' => $saveName, 'ext' => $this->extension, 'config' => $this->config['name'], 'sha1' => $this->hash(), 'size' => $this->size, 'mimes' => $this->clientMimeType];
            $file->fill($fileInfo);
            $file->save();
            $fileInfo = $file;
        }

        $fileInfo = array_merge(is_object($fileInfo) ? $fileInfo->toArray() : $fileInfo, ['url' => $fileInfo->url()]);
        return $fileInfo;
	}
}
