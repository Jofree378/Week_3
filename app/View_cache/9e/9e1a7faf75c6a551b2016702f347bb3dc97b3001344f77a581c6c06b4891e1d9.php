<?php

/* User/header.twig */
class __TwigTemplate_62f5533eba0538524b8340e61803590c6a1a878773bc1f753ec3c42a47f715e4 extends Twig_Template
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
        echo "<!doctype html>
<html>
<head>
    <meta charset=\"utf-8\">
    <title>";
        // line 5
        echo twig_escape_filter($this->env, ($context["title"] ?? null));
        echo "</title>
    <!--  Подключение стилей  -->
    <style>";
        // line 7
        echo twig_escape_filter($this->env, ($context["style"] ?? null));
        echo "</style>
</head>

";
    }

    public function getTemplateName()
    {
        return "User/header.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 7,  25 => 5,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "User/header.twig", "C:\\OpenServer\\domains\\example.local\\app\\View\\User\\header.twig");
    }
}
