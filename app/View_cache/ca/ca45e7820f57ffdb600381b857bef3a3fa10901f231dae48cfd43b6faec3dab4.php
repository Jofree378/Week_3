<?php

/* User/auth.twig */
class __TwigTemplate_e6f22262b5bcd3b3d69ac0ad7c8adf187e48c7f2cf7e132a03a803cd998b998d extends Twig_Template
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
        $this->loadTemplate("User/header.twig", "User/auth.twig", 1)->display($context);
        // line 2
        echo "<body>
<style>";
        // line 3
        echo twig_escape_filter($this->env, ($context["styleBody"] ?? null));
        echo "</style>
<div class=\"register_page\">
    <!--  Форма входа  -->
    <h1 class=\"register-title\">Вход в аккаунт</h1>
    <form action=\"/user/twigAuth\" method=\"post\">
        <div class=\"form-group\">
            <input class=\"input\" type=\"email\" name=\"email\" placeholder=\"Ваш email\">
        </div>

        <div class=\"form-group\">
            <input class=\"input\" type=\"password\" name=\"password\" placeholder=\"Ваш пароль\">
        </div>
        <!--  Вывод сообщений об ошибках  -->
        ";
        // line 16
        $this->loadTemplate("User/error.twig", "User/auth.twig", 16)->display($context);
        // line 17
        echo "        <!--  Кнопка входа  -->
        <div class=\"form-group\">
            <button class=\"btn\" type=\"submit\">Войти</button>
        </div>
    </form>
</div>

</body>
</html>";
    }

    public function getTemplateName()
    {
        return "User/auth.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  42 => 17,  40 => 16,  24 => 3,  21 => 2,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "User/auth.twig", "C:\\OpenServer\\domains\\example.local\\app\\View\\User\\auth.twig");
    }
}
