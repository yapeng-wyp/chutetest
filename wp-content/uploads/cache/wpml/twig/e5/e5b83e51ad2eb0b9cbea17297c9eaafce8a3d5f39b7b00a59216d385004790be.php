<?php

/* dropdown-templates.twig */
class __TwigTemplate_e24a6021362b524042ab4f278936cc01b78e7071f49067353a5a6b82e2774ea6 extends Twig_Template
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
        $context["supported_core_templates"] = array();
        // line 2
        $context["supported_custom_templates"] = array();
        // line 4
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["data"] ?? null), "templates", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["template"]) {
            if (twig_in_filter(($context["slot_type"] ?? null), $this->getAttribute($context["template"], "supported_slot_types", array()))) {
                // line 5
                if ($this->getAttribute($context["template"], "is_core", array())) {
                    // line 6
                    $context["supported_core_templates"] = twig_array_merge(($context["supported_core_templates"] ?? null), array(0 => $context["template"]));
                } else {
                    // line 8
                    $context["supported_custom_templates"] = twig_array_merge(($context["supported_custom_templates"] ?? null), array(0 => $context["template"]));
                }
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['template'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 12
        $context["total_templates"] = (twig_length_filter($this->env, ($context["supported_core_templates"] ?? null)) + twig_length_filter($this->env, ($context["supported_custom_templates"] ?? null)));
        // line 13
        echo "
<div";
        // line 14
        if ((($context["total_templates"] ?? null) <= 1)) {
            echo " class=\"hidden\"";
        }
        echo ">

\t<h4><label for=\"template-";
        // line 16
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", array()), "templates_dropdown_label", array()), "html", null, true);
        echo "</label>";
        $this->loadTemplate("tooltip.twig", "dropdown-templates.twig", 16)->display(array_merge($context, array("content" => $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "tooltips", array()), "available_templates", array()))));
        echo "</h4>

\t<select id=\"template-";
        // line 18
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo "\" name=\"";
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo "\" class=\"js-wpml-ls-template-selector js-wpml-ls-trigger-update\">

\t\t<optgroup label=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", array()), "templates_wpml_group", array()), "html", null, true);
        echo "\">";
        // line 21
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["supported_core_templates"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["template"]) {
            // line 22
            $context["template_data"] = $this->getAttribute($context["template"], "get_template_data", array(), "method");
            // line 23
            echo "\t\t\t<option value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["template_data"] ?? null), "slug", array()), "html", null, true);
            echo "\"";
            if ((($context["value"] ?? null) == $this->getAttribute(($context["template_data"] ?? null), "slug", array()))) {
                echo "selected=\"selected\"";
            }
            echo ">";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["template_data"] ?? null), "name", array()), "html", null, true);
            echo "</option>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['template'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 25
        echo "\t\t</optgroup>";
        // line 27
        if ((twig_length_filter($this->env, ($context["supported_custom_templates"] ?? null)) > 0)) {
            // line 28
            echo "\t\t\t<optgroup label=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", array()), "templates_custom_group", array()), "html", null, true);
            echo "\">";
            // line 29
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["supported_custom_templates"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["template"]) {
                // line 30
                $context["template_data"] = $this->getAttribute($context["template"], "get_template_data", array(), "method");
                // line 31
                echo "\t\t\t\t<option value=\"";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["template_data"] ?? null), "slug", array()), "html", null, true);
                echo "\"";
                if ((($context["value"] ?? null) == $this->getAttribute(($context["template_data"] ?? null), "slug", array()))) {
                    echo "selected=\"selected\"";
                }
                echo ">";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["template_data"] ?? null), "name", array()), "html", null, true);
                echo "</option>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['template'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 33
            echo "\t\t\t</optgroup>";
        }
        // line 35
        echo "
\t</select>

</div>
";
    }

    public function getTemplateName()
    {
        return "dropdown-templates.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  123 => 35,  120 => 33,  106 => 31,  104 => 30,  100 => 29,  96 => 28,  94 => 27,  92 => 25,  78 => 23,  76 => 22,  72 => 21,  69 => 20,  62 => 18,  53 => 16,  46 => 14,  43 => 13,  41 => 12,  33 => 8,  30 => 6,  28 => 5,  23 => 4,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "dropdown-templates.twig", "E:\\laragon\\www\\chutetest\\wp-content\\plugins\\wpmlone\\templates\\language-switcher-admin-ui\\dropdown-templates.twig");
    }
}
