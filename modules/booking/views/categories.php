<?php

/**
 * @filesource modules/booking/views/categories.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Booking\Categories;

use Kotchasan\DataTable;
use Kotchasan\Form;
use Kotchasan\Html;

/**
 * module=booking-categories
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Gcms\View
{
    /**
     * รายการหมวดหมู่
     *
     * @param object $index
     *
     * @return string
     */
    public function render($index)
    {
        $form = Html::create('form', array(
            'id' => 'setup_frm',
            'class' => 'setup_frm',
            'autocomplete' => 'off',
            'action' => 'index.php/booking/model/categories/submit',
            'onsubmit' => 'doFormSubmit',
            'ajax' => true,
            'token' => true,
        ));
        $fieldset = $form->add('fieldset', array(
            'title' => '{LNG_Details of} ' . $index->categories[$index->type],
        ));
        // ตารางหมวดหมู่
        $table = new DataTable(array(
            /* ข้อมูลใส่ลงในตาราง */
            'datas' => \Booking\Categories\Model::toDataTable($index->type),
            /* ฟังก์ชั่นจัดรูปแบบการแสดงผลแถวของตาราง */
            'onRow' => array($this, 'onRow'),
            /* คอลัมน์ที่ไม่ต้องแสดงผล */
            'hideColumns' => array('id'),
            /* กำหนดให้ input ตัวแรก (id) รับค่าเป็นตัวเลขเท่านั้น */
            'onInitRow' => 'initFirstRowNumberOnly',
            'border' => true,
            'responsive' => true,
            'pmButton' => true,
            'showCaption' => false,
            'headers' => array(
                'category_id' => array(
                    'text' => '{LNG_ID}',
                ),
                'topic' => array(
                    'text' => '{LNG_Detail}',
                ),
            ),
        ));
        $fieldset->add('div', array(
            'class' => 'item',
            'innerHTML' => $table->render(),
        ));
        $fieldset = $form->add('fieldset', array(
            'class' => 'submit',
        ));
        // submit
        $fieldset->add('submit', array(
            'class' => 'button save large icon-save',
            'value' => '{LNG_Save}',
        ));
        // type
        $fieldset->add('hidden', array(
            'id' => 'type',
            'value' => $index->type,
        ));
        // คืนค่า HTML
        return $form->render();
    }

    /**
     * จัดรูปแบบการแสดงผลในแต่ละแถว
     *
     * @param array  $item ข้อมูลแถว
     * @param int    $o    ID ของข้อมูล
     * @param object $prop กำหนด properties ของ TR
     *
     * @return array
     */
    public function onRow($item, $o, $prop)
    {
        $item['category_id'] = Form::text(array(
            'name' => 'category_id[]',
            'labelClass' => 'g-input',
            'size' => 2,
            'value' => $item['category_id'],
        ))->render();
        $item['topic'] = Form::text(array(
            'name' => 'topic[]',
            'labelClass' => 'g-input',
            'maxlength' => 128,
            'value' => $item['topic'],
        ))->render();
        return $item;
    }
}
