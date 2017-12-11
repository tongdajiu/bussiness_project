<?php
/**
 * 公告信息设置模型
 */
class AnnouncementModel extends Model{
    public function __construct($db, $table=''){
        $table = 'announcement';
        parent::__construct($db, $table);
    }
}