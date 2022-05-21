<?php

/* table-slots.twig */
class __TwigTemplate_1fb5edd2a8df656192e298835b1427b4138ef0d9aee7a983c39c665d78c69973 extends Twig_Template
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
            $context["table_id"] = ((("wpml-ls-slot-list-" . ($context["slot_type"] ?? null)) . "-") . ($context["slug"] ?? null));
        } else {
            // line 5
            $context["table_id"] = ("wpml-ls-slot-list-" . ($context["slot_type"] ?? null));
        }
        // line 8
        if (twig_in_filter(($context["slug"] ?? null), array(0 => "footer", 1 => "post_translations"))) {
            // line 9
            $context["label_action"] = $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", array()), "label_action", array());
        } else {
            // line 11
            $context["label_action"] = $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", array()), "label_actions", array());
        }
        // line 13
        echo "
<table id=\"";
        // line 14
        echo twig_escape_filter($this->env, ($context["table_id"] ?? null), "html", null, true);
        echo "\" class=\"js-wpml-ls-slot-list wpml-ls-slot-list\"";
        if ( !($context["slots_settings"] ?? null)) {
            echo " style=\"display:none;\"";
        }
        echo ">
    <thead>
    <tr>
        <th>";
        // line 17
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", array()), "label_preview", array()), "html", null, true);
        echo "</th>";
        // line 18
        if ( !($context["is_static"] ?? null)) {
            echo "<th>";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["strings"] ?? null), "misc", array()), "label_position", array()), "html", null, true);
            echo "</th>";
        }
        // line 19
        echo "        <th";
        if ( !($context["is_static"] ?? null)) {
            echo " colspan=\"2\"";
        }
        echo ">";
        echo twig_escape_filter($this->env, ($context["label_action"] ?? null), "html", null, true);
        echo "</th></tr>
    </thead>
    <tbody>";
        // line 22
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["slots_settings"] ?? null));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["slug"] => $context["slot_settings"]) {
            // line 23
            $this->loadTemplate("table-slot-row.twig", "table-slots.twig", 23)->display(array_merge($context, array("slug" =>             // line 25
$context["slug"], "slot_type" =>             // line 26
($context["slot_type"] ?? null), "slot_settings" =>             // line 27
$context["slot_settings"], "slots" =>             // line 28
($context["slots"] ?? null))));
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['slug'], $context['slot_settings'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
        echo "    </tbody>
</table>";
    }

    public function getTemplateName()
    {
        return "table-slots.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  104 => 32,  90 => 28,  89 => 27,  88 => 26,  87 => 25,  86 => 23,  69 => 22,  59 => 19,  53 => 18,  50 => 17,  40 => 14,  37 => 13,  34 => 11,  31 => 9,  29 => 8,  26 => 5,  23 => 3,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "table-slots.twig", "E:\\laragon\\www\\chutetest\\wp-content\\plugins\\wpmlone\\templates\\language-switcher-admin-ui\\table-slots.twig");
    }
}
