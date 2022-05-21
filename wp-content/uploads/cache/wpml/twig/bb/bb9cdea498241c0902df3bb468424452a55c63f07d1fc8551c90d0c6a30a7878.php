<?php

/* dropdown-sidebars.twig */
class __TwigTemplate_5141adf34b5950ee00a1b7f629a9062f4bbccd3387a33f80ad8378a3ec51abbd extends Twig_Template
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
        echo "<h4><label for=\"wpml-ls-available-sidebars\">";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "sidebars", array()), "select_label", array()), "html", null, true);
        echo ":</label>";
        $this->loadTemplate("tooltip.twig", "dropdown-sidebars.twig", 1)->display(array_merge($context, array("content" => $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "tooltips", array()), "available_sidebars", array()))));
        echo "</h4>
<select name=\"wpml_ls_available_sidebars\" class=\"js-wpml-ls-available-slots js-wpml-ls-available-sidebars\">
    <option disabled=\"disabled\">--";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "sidebars", array()), "select_option_choose", array()), "html", null, true);
        echo " --</option>";
        // line 4
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["sidebars"] ?? null));
        foreach ($context['_seq'] as $context["sidebar_key"] => $context["sidebar"]) {
            // line 5
            if (($context["sidebar_key"] == ($context["slug"] ?? null))) {
                // line 6
                $context["attr"] = " selected=\"selected\"";
            } elseif (twig_in_filter($this->getAttribute(            // line 7
$context["sidebar"], "id", array()), twig_get_array_keys_filter($this->getAttribute(($context["settings"] ?? null), "sidebar", array())))) {
                // line 8
                $context["attr"] = " disabled=\"disabled\"";
            } else {
                // line 10
                $context["attr"] = "";
            }
            // line 12
            echo "        <option value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["sidebar"], "id", array()), "html", null, true);
            echo "\"";
            echo twig_escape_filter($this->env, ($context["attr"] ?? null), "html", null, true);
            echo ">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["sidebar"], "name", array()), "html", null, true);
            echo "</option>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['sidebar_key'], $context['sidebar'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 14
        echo "</select>
";
    }

    public function getTemplateName()
    {
        return "dropdown-sidebars.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  58 => 14,  46 => 12,  43 => 10,  40 => 8,  38 => 7,  36 => 6,  34 => 5,  30 => 4,  27 => 3,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "dropdown-sidebars.twig", "E:\\laragon\\www\\chutetest\\wp-content\\plugins\\wpmlone\\templates\\language-switcher-admin-ui\\dropdown-sidebars.twig");
    }
}
