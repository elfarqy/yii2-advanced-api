<?php

namespace console\components;

class Migration extends \yii\db\Migration {
  /**
   * @var string
   */
  protected $tableOptions;

  /**
   * @inheritdoc
   */
  public function init() {
    parent::init();

    // switch based on driver name
    switch (\Yii::$app->db->driverName) {
      case 'mysql':
        $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        break;
      case 'pgsql':
        $this->tableOptions = null;
        break;
      default:
        throw new \RuntimeException('Your database is not supported!');
    }
  }
}