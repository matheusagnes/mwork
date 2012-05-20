<?php

class MMenu
{

    private $target = 'conteudo';
    private $links;
    private $style;
    private $is_vertical;
    private $id;
    
    public function __construct($id = 'menu',$is_vertical = true)
    {
        $this->id = $id;
        $this->is_vertical = $is_vertical;
    }

    public function addLink($label, $url, $icon = null,$js_function = null, $params = null)
    {
        $link->url = $url;
        $link->label = $label;
        $link->js_function = $js_function;
        $link->params = $params;
        $link->icon = $icon;
        $this->links[] = $link;
    }

    public function show()
    {
        $class = $this->is_vertical ? 'portlet': 'menu_vertical';
        
        $menu = "<div id = '{$this->id}' class='{$class}'>";
        $menu .= '<div class="portlet-decoration">
                    <div class="portlet-title">
                        <span class="icon icon-sitemap_color">Operações</span>
                    </div>
                 </div>';   
        if($this->links)
        {
            $menu.='<div class="portlet-content"> <ul class="operations" >';
            foreach ($this->links as $link)
            {
                unset($img);
                unset($linkUrl);
                if(!$js_function && $link->url)
                {
                    if($link->icon)
                    {
                        $img = "<img src = '{$link->icon}'> ";
                    }
                    $linkUrl = "<li> <a href='{$link->url}'> {$link->label} {$img}</a> </li>";
                }
                $menu.= $linkUrl;
            }
            
            $menu.='</ul></div></div>';
        }
        echo $menu;
        
    }

}

?>


