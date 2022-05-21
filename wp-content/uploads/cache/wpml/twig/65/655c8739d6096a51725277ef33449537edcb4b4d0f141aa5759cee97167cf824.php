<?php

/* button-add-new-ls.twig */
class __TwigTemplate_8cec491448fa613a91b55b2a7c78a04083baae47762f9bdb09252f5632cee3cc extends Twig_Template
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
        echo "<p class=\"alignright\">";
        // line 3
        $context["add_tooltip"] = ($context["tooltip_all_assigned"] ?? null);
        // line 5
        if ((($context["existing_items"] ?? null) == 0)) {
            // line 6
            $context["add_tooltip"] = ($context["tooltip_no_item"] ?? null);
        }
        // line 9
        if ((($context["settings_items"] ?? null) >= ($context["existing_items"] ?? null))) {
            // line 10
            $context["disabled"] = true;
        }
        // line 12
        echo "
\t<span class=\"js-wpml-ls-tooltip-wrapper";
        // line 13
        if ( !($context["disabled"] ?? null)) {
            echo " hidden";
        }
        echo "\">";
        // line 14
        $this->loadTemplate("tooltip.twig", "button-add-new-ls.twig", 14)->display(array_merge($context, array("content" => ($context["add_tooltip"] ?? null))));
        // line 15
        echo "    </span>

\t<button class=\"js-wpml-ls-open-dialog button-secondary\"";
        // line 17
        if (($context["disabled"] ?? null)) {
            echo " disabled=\"disabled\"";
        }
        // line 18
        echo "\t\t\tdata-target=\"";
        echo twig_escape_filter($this->env, ($context["button_target"] ?? null), "html", null, true);
        echo "\">+";
        echo twig_escape_filter($this->env, ($context["button_label"] ?? null), "html", null, true);
        echo "</button>
</p>";
    }

    public function getTemplateName()
    {
        return "button-add-new-ls.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 18,  47 => 17,  43 => 15,  41 => 14,  36 => 13,  33 => 12,  30 => 10,  28 => 9,  25 => 6,  23 => 5,  21 => 3,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "button-add-new-ls.twig", "E:\\laragon\\www\\chutetest\\wp-content\\plugins\\wpmic\\templates\\language-switcher-admin-ui\\button-add-new-ls.twig");
    }
}
