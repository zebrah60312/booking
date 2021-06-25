<?php

/**
 * @filesource Gcms/Modules.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Gcms;

/**
 * Config Class สำหรับ GCMS
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Modules extends \Kotchasan\KBase
{
    /**
     * Singleton สำหรับเรียกใช้ class นี้เพียงครั้งเดียวเท่านั้น
     *
     * @var static
     */
    private static $instance = null;
    /**
     * @var array
     */
    private $modules = array();
    /**
     * ไดเร็คทอรี่ของโมดูล
     *
     * @var string
     */
    private $dir;

    /**
     * ตรวจสอบโมดูลที่ติดตั้งแล้ว
     */
    private function __construct()
    {
        if (!empty(self::$cfg->modules)) {
            foreach (self::$cfg->modules as $module => $published) {
                if ($published) {
                    $this->modules[] = $module;
                }
            }
        }
        $this->dir = ROOT_PATH . 'modules/';
        $f = @opendir($this->dir);
        if ($f) {
            while (false !== ($text = readdir($f))) {
                if (!preg_match('/\.|index|css|js|v[0-9]+/', $text) && is_dir($this->dir . $text)) {
                    if (!in_array($text, $this->modules) && !isset(self::$cfg->modules[$text])) {
                        $this->modules[] = $text;
                    }
                }
            }
            closedir($f);
        }
    }

    /**
     * โหลดโมดูลที่ติดตั้งแล้วทั้งหมด
     *
     * @return \static
     */
    public static function create()
    {
        if (null === self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * คืนค่าชื่อโมดูลทั้งหมดที่ติดตั้งแล้ว
     *
     * @return array
     */
    public function get()
    {
        return $this->modules;
    }

    /**
     * คืนค่า $className ทั้งหมดของโมดูลที่ติดตั้งแล้ว
     *
     * @param string $className ชื่อคลาสที่ต้องการ เช่น Init
     *
     * @return array
     */
    public function getControllers($className)
    {
        $result = array();
        $file = strtolower($className);
        foreach ($this->modules as $module) {
            if (is_file($this->dir . $module . '/controllers/' . $file . '.php')) {
                require_once $this->dir . $module . '/controllers/' . $file . '.php';
                $result[] = '\\' . ucfirst($module) . '\\' . $className . '\Controller';
            }
        }
        return $result;
    }

    /**
     * คืนค่าไดเร็คทอรี่โมดูล
     *
     * @return string
     */
    public function getDir()
    {
        return $this->dir;
    }
}
