<?php
/**
 * 文章模型
 */
class ArticleModel extends Model{

    public function __construct($db, $table=''){
        $table = 'article';
        parent::__construct($db, $table);
    }
    
    /**
     * 获取类型与分类的所属关系
     */
    public function getTypeCateMap(){
    	$list = array();
    	$cates = $this->getAll(array(), array(), ARRAY_A, '', '', 'article_type');
    	foreach($cates as $v){
    		$list[$v['type']][] = $v;
    	}
    	return $list;
    }
    
}
?>