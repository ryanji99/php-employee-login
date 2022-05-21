<?php
namespace Utils;
class View {
    protected $template_dir = 'views/';
    protected $vars = array();
    public function __construct($template_dir = null) {
        if ($template_dir !== null) {
            // Check here whether this directory really exists
            $this->template_dir = $template_dir;
        }
    }
    public function render($template_file) {
        if (file_exists($this->template_dir.$template_file)) {
            include $this->template_dir.$template_file;
        } else {

        }
    }
    public function __set($name, $value) {
        $this->vars[$name] = $value;
    }
    public function __get($name) {
        return $this->vars[$name];
    }
}
?>