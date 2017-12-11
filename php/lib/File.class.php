<?php
class File{
    public static $DS = DIRECTORY_SEPARATOR;

    /**
     * 判断是否目录
     *
     * @param string $dir 目录路径
     * @return boolean
     */
    public static function isDir($dir){
        return is_dir($dir);
    }

    /**
     * 判断是否文件
     *
     * @param string $file 文件路径
     * @return boolean
     */
    public static function isFile($file){
        return is_file($file);
    }

    /**
     * 判断是否可读
     *
     * @param string $file 文件或目录路径
     * @return boolean
     */
    public static function isReadable($file){
        return is_readable($file);
    }

    /**
     * 判断是否可写
     *
     * @param string $file 文件或目录路径
     * @return boolean
     */
    public static function isWritable($file){
        return is_writable($file);
    }

    /**
     * 创建目录
     *
     * @param string $dir 目录路径
     * @param integer $mode 模式
     * @param boolean $recursive 是否递归
     * @return boolean
     */
    public static function createDir($dir, $mode=0777, $recursive=true){
        return mkdir($dir, $mode, $recursive);
    }

    /**
     * 复制
     *
     * @param string $ori 原路径
     * @param string $dest 目标路径
     * @return boolean
     */
    public static function copy($ori, $dest){
        return copy($ori, $dest);
    }

    /**
     * 移到
     *
     * @param string $ori 源路径
     * @param string $dest 目标路径
     * @return boolean
     */
    public static function move($ori, $dest){
        return rename($ori, $dest);
    }

    /**
     * 获取文件或目录的信息
     *
     * @param string $file 文件或目录路径
     * @return array
     */
    public static function info($file){}

    /**
     * 删除文件或目录
     *
     * @param string $path 文件或目录路径
     * @return boolean
     */
    public static function delete($path){
        if(self::isFile($path)){
            unlink($path);
        }elseif(self::isDir($path)){
            $list = self::scan($path);
            foreach($list as $v){
                self::delete($path.self::$DS.$v);
            }
        }
    }

    /**
     * 获取目录中的文件
     *
     * @param string $dir 目录路径
     * @return array
     */
    public static function scan($dir){
        $list = array();
        if(self::isDir($dir)){
            $rs = scandir($dir);
            if($rs !== false){
                foreach($rs as $v){
                    if(($v != '.') && ($v != '..')){
                        $tmpFile = $dir.self::$DS.$v;
                        $tmp = array('name'=>$v, 'path'=>$dir.self::$DS.$v);
                        if(self::isDir($tmpFile)){
                            $tmp['type'] = 'dir';
                        }elseif(self::isFile($tmpFile)){
                            $tmp['type'] = 'file';
                        }
                        $list[] = $tmp;
                    }
                }
            }
        }
        return $list;
    }

    /**
     * 获取文件的扩展名
     *
     * @param string $file 文件路径
     * @return string
     */
    public static function extension($file){
        return substr($file, strripos($file, '.')+1);
    }

    /**
     * 读取文件内容
     *
     * @param string $file 文件路径
     * @return string|boolean
     */
    public static function read($file){
        $handle = fopen($file, 'r');
        if($handle === false) return false;
        return fread($handle, filesize($file));
    }

    /**
     * 写入内容
     *
     * @param string $file 文件路径
     * @param string $content 内容
     * @param boolean $isNew 是否为新内容
     * @return integer|boolean
     */
    public static function write($file, $content, $isNew=true){
        $openType = $isNew ? 'w+' : 'a+';
        $handle = fopen($file, $openType);
        if($handle === false) return false;
        return fwrite($handle, $content);
    }
}
?>