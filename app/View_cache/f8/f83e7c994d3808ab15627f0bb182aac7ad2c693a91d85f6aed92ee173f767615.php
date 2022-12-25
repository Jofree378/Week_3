<?php

/* Blog/index.twig */
class __TwigTemplate_92a17f1906cc9426d1d02cf728dbb296e1dd53f07ca17f73dee22baba2fbe198 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->loadTemplate("User/header.twig", "Blog/index.twig", 1)->display($context);
        // line 2
        echo "<style>";
        echo twig_escape_filter($this->env, ($context["styleBody"] ?? null));
        echo "</style>
<!-- Вывод сообщений по api -->
";
        // line 4
        if ((($context["user"] ?? null) == twig_get_attribute($this->env, $this->getSourceContext(), ($context["admin"] ?? null), 0, array()))) {
            // line 5
            echo "<form action=\"/api/getUserPosts/?user_id=<?= \$_GET['id'] ?>\" method=\"get\">
    <input type=\"text\" name=\"user_id\" placeholder=\"Ввести id\">
    <input type=\"submit\" value='Найти'>
</form>
";
        }
        // line 10
        echo "<body>
<div class=\"user\"> Ваш email: ";
        // line 11
        echo twig_escape_filter($this->env, ($context["userEmail"] ?? null), "html", null, true);
        echo "</div>
<div class=\"homePage\">
    <!--  Форма выхода  -->
    <form action=\"/user/logout\">
        <input class=\"quit\" type=\"submit\" value=\"Выйти\">
    </form>
    <!--  Форма ввода сообщений  -->
    <form enctype=\"multipart/form-data\" action=\"/blog/twigIndex\" method=\"post\">
        <div class=\"form-group\">
            <label for=\"message\">Введите сообщение:</label>
            <textarea class=\"form-textarea\" name=\"message\" placeholder=\"Ваш текст\" id=\"message\"></textarea>
            <label class=\"labelFile\" for=\"file\">Прикрепить картинку:</label>
            <input class=\"btn2\" type=\"file\" name=\"userFile\" id=\"file\">
            <input class=\"btn\" type=\"submit\" value=\"Отправить\">
        </div>
    </form>
    <!--  Вывод сообщений  -->
    <div class=\"border\"></div>
    ";
        // line 29
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["posts"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["post"]) {
            // line 30
            echo "        ";
            $context["user_id"] = twig_get_attribute($this->env, $this->getSourceContext(), $context["post"], "user_id", array());
            // line 31
            echo "    <div class=\"post\">
        <span class=\"postUser\">Сообщение от <b> ";
            // line 32
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["postByUsers"] ?? null), ($context["user_id"] ?? null), array(), "array"), "name", array()), "html", null, true);
            echo "</b> Отправлено ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["post"], "datetime", array()), "html", null, true);
            echo "</span>
        <div class=\"message\">";
            // line 33
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["post"], "message", array()), "html", null, true);
            echo "</div>
        ";
            // line 34
            $context["file"] = (("../images/" . twig_get_attribute($this->env, $this->getSourceContext(), $context["post"], "post_id", array())) . ".png");
            // line 35
            echo "        ";
            if (($context["file"] ?? null)) {
                // line 36
                echo "        <img class=\"image\" src=\"/blog/image/?post_id=";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["post"], "post_id", array()), "html", null, true);
                echo "\" alt=\"\">
        ";
            }
            // line 38
            echo "        ";
            if ((($context["user"] ?? null) == twig_get_attribute($this->env, $this->getSourceContext(), ($context["admin"] ?? null), 0, array()))) {
                // line 39
                echo "        <a class=\"delete\" href=\"/admin/delete/?id=";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["post"], "post_id", array()), "html", null, true);
                echo "\">Удалить</a>
        ";
            }
            // line 41
            echo "    </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['post'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 43
        echo "
</div>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "Blog/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  107 => 43,  100 => 41,  94 => 39,  91 => 38,  85 => 36,  82 => 35,  80 => 34,  76 => 33,  70 => 32,  67 => 31,  64 => 30,  60 => 29,  39 => 11,  36 => 10,  29 => 5,  27 => 4,  21 => 2,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "Blog/index.twig", "C:\\OpenServer\\domains\\example.local\\app\\View\\Blog\\index.twig");
    }
}
