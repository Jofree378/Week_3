<?php

/* User/error.twig */
class __TwigTemplate_ae5a1c38c3d02a762547b56fe554b2ed2ad48f657d2858a8a2641b97f27db099 extends Twig_Template
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
        if (($context["error"] ?? null)) {
            // line 2
            echo "    <span class=\"error\">";
            echo twig_escape_filter($this->env, ($context["error"] ?? null), "html", null, true);
            echo "</span>
";
        }
    }

    public function getTemplateName()
    {
        return "User/error.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  21 => 2,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "User/error.twig", "C:\\OpenServer\\domains\\example.local\\app\\View\\User\\error.twig");
    }
}
