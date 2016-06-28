<?php

use yii\db\Schema;
use yii\db\Migration;

class m160628_162951_add_demo_data extends Migration
{
    public function up()
    {
        $this->execute(<<<EOF
INSERT INTO `domains` (`id`, `domain`, `name`, `description`, `logo`, `status`, `createTime`) VALUES
('96670574394212352', 'demo1', '蜀国', NULL, NULL, 1, '2016-06-27 09:28:29');

INSERT INTO `users` (`id`, `email`, `name`, `title`, `phone`, `avatar`, `description`, `password`, `salt`, `did`, `isAdmin`, `createTime`, `lastActivity`, `accessToken`, `status`, `loginStatus`) VALUES
('96670574394212353', 'admin@demo1.com', '刘备', '总经理', '18612344321', NULL, '一个很好的人', 'dfb18a934f2f5f6e77b693e5dfee0e8a', '117314', '96670574394212352', 1, '2016-06-27 09:28:29', '2016-06-28 16:22:19', '5309fbf220bf09b0fe565f93c8bba76c', 1, 1),
('96670574394212354', 'demo1@demo1.com', '张飞', 'PHP工程师', '13812344321', NULL, '一个很苦逼的人', '8e9a44f0d2352661bd96129b73c6b35a', '227934', '96670574394212352', 0, '2016-06-27 09:44:54', '2016-06-28 08:12:20', '381001053f8f1fc58a1f1be004a6a35e', 1, 0),
('96670574394212355', 'demo2@demo1.com', '关羽', '后端工程师', '15812344321', NULL, '一个很猛的人', '39084d8b679aa5d3c3b8e232d570beaa', '702670', '96670574394212352', 0, '2016-06-27 09:45:11', '2016-06-27 18:02:59', '2b2f9a163f566c3093293c98a523a804', 1, 0);
EOF
);
    }

    public function down()
    {
        $this->delete('{{domains}}', ['id' => '96670574394212352']);
        $this->delete('{{users}}', ['did' => '96670574394212352']);
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
