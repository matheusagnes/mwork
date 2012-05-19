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
        $class = $this->is_vertical ? 'menu_vertical': 'menu_horizontal';
        
        $menu = "<div id = '{$this->id}' class='{$class}'>";
        if($this->links)
        {
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
                    $linkUrl = "<div> <a href='{$link->url}'> {$link->label} {$img}</a> </div>";
                }
                $menu.= $linkUrl;
            }
            $menu.='</div>';
        }
        echo $menu;
        
    }

}

?>


<!--<div class="portlet" id="yw2">
<div class="portlet-decoration">
<div class="portlet-title"><span class="icon icon-sitemap_color">Operations</span></div>
</div>
<div class="portlet-content">
<ul class="operations" id="yw3">
<li><a href="/themes/index.php?r=theme/create">Create Theme</a></li>
<li><a href="/themes/index.php?r=theme/admin">Manage Theme</a></li>
</ul></div>
</div>-->