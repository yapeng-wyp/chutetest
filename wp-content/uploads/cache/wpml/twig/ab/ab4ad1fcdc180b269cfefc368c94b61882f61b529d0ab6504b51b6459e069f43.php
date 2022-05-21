<?php

/* slot-subform-menus.twig */
class __TwigTemplate_e7f10e9927e9d41c3e722ca1ef638e76fac8da8f555f611eea57303688dd7a96 extends Twig_Template
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
        if ( !array_key_exists("slot_settings", $context)) {
            // line 2
            $context["slot_settings"] = ($context["default_menus_slot"] ?? null);
        }
        // line 5
        $this->loadTemplate("preview.twig", "slot-subform-menus.twig", 5)->display(array_merge($context, array("preview" => ($context["preview"] ?? null))));
        // line 6
        echo "
<div class=\"wpml-ls-subform-options\">";
        // line 9
        $this->loadTemplate("dropdown-menus.twig", "slot-subform-menus.twig", 9)->display(array_merge($context, array("slug" =>         // line 11
($context["slug"] ?? null), "menus" =>         // line 12
($context["slots"] ?? null))));
        // line 16
        $this->loadTemplate("dropdown-templates.twig", "slot-subform-menus.twig", 16)->display(array_merge($context, array("id" => ("in-menus-" .         // line 18
($context["slug"] ?? null)), "name" => (("menus[" .         // line 19
($context["slug"] ?? null)) . "][template]"), "value" => $this->getAttribute(        // line 20
($context["slot_settings"] ?? null), "template", array()), "slot_type" => "menus")));
        // line 25
        $this->loadTemplate("radio-position-menu.twig", "slot-subform-menus.twig", 25)->display(array_merge($context, array("name_base" => (("menus[" .         // line 27
($context["slug"] ?? null)) . "]"), "slot_settings" =>         // line 28
($context["slot_settings"] ?? null))));
        // line 32
        $this->loadTemplate("radio-hierarchical-menu.twig", "slot-subform-menus.twig", 32)->display(array_merge($context, array("name_base" => (("menus[" .         // line 34
($context["slug"] ?? null)) . "]"), "slot_settings" =>         // line 35
($context["slot_settings"] ?? null))));
        // line 40
        $this->loadTemplate("checkboxes-includes.twig", "slot-subform-menus.twig", 40)->display(array_merge($context, array("name_base" => (("menus[" .         // line 42
($context["slug"] ?? null)) . "]"), "slot_settings" =>         // line 43
($context["slot_settings"] ?? null), "template_slug" => $this->getAttribute(        // line 44
($context["slot_settings"] ?? null), "template", array()))));
        // line 48
        $this->loadTemplate("panel-colors.twig", "slot-subform-menus.twig", 48)->display(array_merge($context, array("id" => ("in-menus-" .         // line 50
($context["slug"] ?? null)), "name_base" => (("menus[" .         // line 51
($context["slug"] ?? null)) . "]"), "slot_settings" =>         // line 52
($context["slot_settings"] ?? null), "slot_type" => "menus")));
        // line 56
        echo "
</div>";
    }

    public function getTemplateName()
    {
        return "slot-subform-menus.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  56 => 56,  54 => 52,  53 => 51,  52 => 50,  51 => 48,  49 => 44,  48 => 43,  47 => 42,  46 => 40,  44 => 35,  43 => 34,  42 => 32,  40 => 28,  39 => 27,  38 => 25,  36 => 20,  35 => 19,  34 => 18,  33 => 16,  31 => 12,  30 => 11,  29 => 9,  26 => 6,  24 => 5,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "slot-subform-menus.twig", "E:\\laragon\\www\\chutetest\\wp-content\\plugins\\wpmlone\\templates\\language-switcher-admin-ui\\slot-subform-menus.twig");
    }
}
