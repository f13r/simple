<?php

class View {

    public $template_view = 'template_view.php';
    public $controller = '';
    public $action = '';

    /*
      $content_file - виды отображающие контент страниц;
      $template_file - общий для всех страниц шаблон;
      $data - массив, содержащий элементы контента страницы. Обычно заполняется в модели.
     */

    function generate($content_view, $template_view) {

        /*
          if(is_array($data)) {

          // преобразуем элементы массива в переменные
          extract($data);
          }
         */

        /*
          динамически подключаем общий шаблон (вид),
          внутри которого будет встраиваться вид
          для отображения контента конкретной страницы.
         */
        include 'application/views/' . $template_view;
    }

    function render() {
        $controller = strtolower($this->controller);
        $view_file = "application/views/" . $controller . '/' . $this->action . '.phtml';
        if (file_exists($view_file)) {
            \ob_start();
            include_once  $view_file;
            $this->content = \ob_get_clean();
        }


         include 'application/views/' . $this->template_view;
    }

}
