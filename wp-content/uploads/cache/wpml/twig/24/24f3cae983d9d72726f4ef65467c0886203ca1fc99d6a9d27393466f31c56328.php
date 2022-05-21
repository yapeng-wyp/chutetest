<?php

/* slot-subform-statics-post_translations.twig */
class __TwigTemplate_9978cf6a4666780a2c05c7b3b67cba4b9048997e21d32fa806b96e4d5f539ac2 extends Twig_Template
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
        $this->loadTemplate("preview.twig", "slot-subform-statics-post_translations.twig", 1)->display(array_merge($context, array("preview" => $this->getAttribute($this->getAttribute(($context["previews"] ?? null), "statics", array()), "post_translations", array()))));
        // line 2
        echo "
<div class=\"wpml-ls-subform-options\">";
        // line 5
        $this->loadTemplate("dropdown-templates.twig", "slot-subform-statics-post_translations.twig", 5)->display(array_merge($context, array("id" => "in-post-translations", "name" => "statics[post_translations][template]", "value" => $this->getAttribute($this->getAttribute($this->getAttribute(        // line 9
($context["settings"] ?? null), "statics", array()), "post_translations", array()), "template", array()), "slot_type" => "post_translations")));
        // line 14
        $this->loadTemplate("checkboxes-includes.twig", "slot-subform-statics-post_translations.twig", 14)->display(array_merge($context, array("name_base" => "statics[post_translations]", "slot_settings" => $this->getAttribute($this->getAttribute(        // line 17
($context["settings"] ?? null), "statics", array()), "post_translations", array()), "template_slug" => $this->getAttribute(        // line 18
($context["slot_settings"] ?? null), "template", array()))));
        // line 21
        echo "
\t<h4><label>";
        // line 22
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "post_translations", array()), "position_label", array()), "html", null, true);
        echo "</label>";
        $this->loadTemplate("tooltip.twig", "slot-subform-statics-post_translations.twig", 22)->display(array_merge($context, array("content" => $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "tooltips", array()), "post_translation_position", array()))));
        echo "</h4>
\t<ul>
\t\t<li>
\t\t\t<label>
\t\t\t\t<input type=\"checkbox\" name=\"statics[post_translations][display_before_content]\"
\t\t\t\t\t   id=\"wpml-ls-before-in-post-translations\"
\t\t\t\t\t   value=\"1\"";
        // line 28
        if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "statics", array()), "post_translations", array()), "display_before_content", array())) {
            echo " checked=\"checked\"";
        }
        echo ">";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "post_translations", array()), "position_above", array()), "html", null, true);
        echo "
\t\t\t</label>
\t\t</li>
\t\t<li>
\t\t\t<label>
\t\t\t\t<input type=\"checkbox\"  name=\"statics[post_translations][display_after_content]\"
\t\t\t\t\t   id=\"wpml-ls-after-in-post-translations\"
\t\t\t\t\t   value=\"1\"";
        // line 35
        if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "statics", array()), "post_translations", array()), "display_after_content", array())) {
            echo " checked=\"checked\"";
        }
        echo ">";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "post_translations", array()), "position_below", array()), "html", null, true);
        echo "
\t\t\t</label>
\t\t</li>
\t</ul>";
        // line 40
        if (twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "statics", array()), "post_translations", array()), "availability_text", array()))) {
            // line 41
            $context["availability_text"] = $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "post_translations", array()), "default_alternative_languages_text", array());
        } else {
            // line 43
            $context["availability_text"] = $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "statics", array()), "post_translations", array()), "availability_text", array());
        }
        // line 45
        echo "
\t<h4><label>";
        // line 46
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "post_translations", array()), "label_alternative_languages_text", array()), "html", null, true);
        echo "</label>";
        $this->loadTemplate("tooltip.twig", "slot-subform-statics-post_translations.twig", 46)->display(array_merge($context, array("content" => $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "tooltips", array()), "alternative_languages_text", array()))));
        echo "</h4>
\t<input type=\"text\" class=\"js-wpml-ls-trigger-update\"
\t\t   name=\"statics[post_translations][availability_text]\" value=\"";
        // line 48
        echo twig_escape_filter($this->env, ($context["availability_text"] ?? null), "html", null, true);
        echo "\" size=\"40\">

</div>";
    }

    public function getTemplateName()
    {
        return "slot-subform-statics-post_translations.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  87 => 48,  80 => 46,  77 => 45,  74 => 43,  71 => 41,  69 => 40,  59 => 35,  45 => 28,  34 => 22,  31 => 21,  29 => 18,  28 => 17,  27 => 14,  25 => 9,  24 => 5,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "slot-subform-statics-post_translations.twig", "E:\\laragon\\www\\chutetest\\wp-content\\plugins\\wpmic\\templates\\language-switcher-admin-ui\\slot-subform-statics-post_translations.twig");
    }
}
