<?php

/* User/register.twig */
class __TwigTemplate_55354b8d10aa9fc0e64c3ad61902dbc8c988d18677ae5dde7ad3e48f7702839b extends Twig_Template
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
        $this->loadTemplate("User/header.twig", "User/register.twig", 1)->display($context);
        // line 2
        echo "<body>
<style>";
        // line 3
        echo twig_escape_filter($this->env, ($context["styleBody"] ?? null));
        echo "</style>
<div class=\"register_page\">
    <!--  Форма регистрации  -->
    <h1 class=\"register-title\">Регистрация</h1>
    <form action=\"/user/twigRegister\" method=\"post\">
        <div class=\"form-group\">
            <input class=\"input\" type=\"text\" name=\"name\" placeholder=\"Ваше имя\">
        </div>

        <div class=\"form-group\">
            <input class=\"input\" type=\"email\" name=\"email\" placeholder=\"Ваш email\">
        </div>

        <div class=\"form-group\">
            <input class=\"input\" type=\"password\" name=\"password\" placeholder=\"Ваш пароль\">
        </div>

        <div class=\"form-group\">
            <input class=\"input\" type=\"password\" name=\"password-confirm\" placeholder=\"Повторите пароль\">
        </div>

        <div class=\"form-group\">
            <button class=\"btn\" type=\"submit\">Зарегистрироваться</button>
        </div>
        <!--  Вывод сообщений об ошибках  -->

        <div class=\"form-group\">";
        // line 29
        $this->loadTemplate("User/error.twig", "User/register.twig", 29)->display($context);
        echo "</div>

        <!--  Кнопка входа  -->
        <div class=\"form-group\">
            <a href=\"/user/authRedirectTwig\">Войти</a>
        </div>

    </form>
</div>

</body>
</html>";
    }

    public function getTemplateName()
    {
        return "User/register.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  53 => 29,  24 => 3,  21 => 2,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "User/register.twig", "C:\\OpenServer\\domains\\example.local\\app\\View\\User\\register.twig");
    }
}
