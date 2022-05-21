<?php

/* table-slot-row.twig */
class __TwigTemplate_6b0a1531dba373c32c8a62f50a011ae00b68c809f32859ae9905e09ea8cf5290 extends Twig_Template
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
        if ((($context["slot_type"] ?? null) == "statics")) {
            // line 2
            $context["is_static"] = true;
            // line 3
            $context["dialog_title"] = $this->getAttribute($this->getAttribute(($context["strings"] ?? null), ($context["slug"] ?? null), array(), "array"), "dialog_title", array());
            // line 4
            $context["include_row"] = (((("slot-subform-" . ($context["slot_type"] ?? null)) . "-") . ($context["slug"] ?? null)) . ".twig");
        } else {
            // line 6
            $context["dialog_title"] = $this->getAttribute($this->getAttribute(($context["strings"] ?? null), ($context["slot_type"] ?? null), array(), "array"), "dialog_title", array());
            // line 7
            $context["include_row"] = (("slot-subform-" . ($context["slot_type"] ?? null)) . ".twig");
        }
        // line 10
        $context["slot_row_id"] = ((("wpml-ls-" . ($context["slot_type"] ?? null)) . "-row-") . ($context["slug"] ?? null));
        // line 11
        echo "<tr id=\"";
        echo twig_escape_filter($this->env, ($context["slot_row_id"] ?? null), "html", null, true);
        echo "\" class=\"js-wpml-ls-row\" data-item-slug=\"";
        echo twig_escape_filter($this->env, ($context["slug"] ?? null), "html", null, true);
        echo "\" data-item-type=\"";
        echo twig_escape_filter($this->env, ($context["slot_type"] ?? null), "html", null, true);
        echo "\">
    <td class=\"wpml-ls-cell-preview\">
        <div class=\"js-wpml-ls-subform wpml-ls-subform\" data-origin-id=\"";
        // line 13
        echo twig_escape_filter($this->env, ($context["slot_row_id"] ?? null), "html", null, true);
        echo "\" data-title=\"";
        echo twig_escape_filter($this->env, ($context["dialog_title"] ?? null), "html", null, true);
        echo "\" data-item-slug=\"";
        echo twig_escape_filter($this->env, ($context["slug"] ?? null), "html", null, true);
        echo "\" data-item-type=\"";
        echo twig_escape_filter($this->env, ($context["slot_type"] ?? null), "html", null, true);
        echo "\">";
        // line 14
        if (($context["slot_settings"] ?? null)) {
            // line 15
            $this->loadTemplate(($context["include_row"] ?? null), "table-slot-row.twig", 15)->display(array_merge($context, array("slug" =>             // line 17
($context["slug"] ?? null), "slot_settings" =>             // line 18
($context["slot_settings"] ?? null), "settings" =>             // line 19
($context["settings"] ?? null), "slots" =>             // line 20
($context["slots"] ?? null), "strings" =>             // line 21
($context["strings"] ?? null), "preview" => $this->getAttribute($this->getAttribute(            // line 22
($context["previews"] ?? null), ($context["slot_type"] ?? null), array(), "array"), ($context["slug"] ?? null), array(), "array"), "color_schemes" =>             // line 23
($context["color_schemes"] ?? null))));
        }
        // line 27
        echo "        </div>
    </td>";
        // line 30
        if ( !($context["is_static"] ?? null)) {
            // line 31
            echo "    <td>
        <span class=\"js-wpml-ls-row-title\">";
            // line 32
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["slots"] ?? null), ($context["slug"] ?? null), array(), "array"), "name", array()), "html", null, true);
            echo "</span>
    </td>";
        }
        // line 35
        echo "
\t<td class=\"wpml-ls-cell-action\">
        <a href=\"#\" title=\"";
        // line 37
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", array()), "title_action_edit", array()), "html", null, true);
        echo "\" class=\"js-wpml-ls-row-edit wpml-ls-row-edit\"><i class=\"otgs-ico-edit\"></i></a>
    </td>";
        // line 40
        if ( !($context["is_static"] ?? null)) {
            // line 41
            echo "    <td class=\"wpml-ls-cell-action\">
        <a href=\"#\" title=\"";
            // line 42
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", array()), "title_action_delete", array()), "html", null, true);
            echo "\" class=\"js-wpml-ls-row-remove wpml-ls-row-remove\"><i class=\"otgs-ico-delete\"></i></a>
    </td>";
        }
        // line 45
        echo "</tr>";
    }

    public function getTemplateName()
    {
        return "table-slot-row.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  97 => 45,  92 => 42,  89 => 41,  87 => 40,  83 => 37,  79 => 35,  74 => 32,  71 => 31,  69 => 30,  66 => 27,  63 => 23,  62 => 22,  61 => 21,  60 => 20,  59 => 19,  58 => 18,  57 => 17,  56 => 15,  54 => 14,  45 => 13,  35 => 11,  33 => 10,  30 => 7,  28 => 6,  25 => 4,  23 => 3,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "table-slot-row.twig", "E:\\laragon\\www\\chutetest\\wp-content\\plugins\\wpmic\\templates\\language-switcher-admin-ui\\table-slot-row.twig");
    }
}
