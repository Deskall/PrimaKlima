
<div class="list-element__container $BlocksPerLine  uk-flex uk-grid-small <% if $Border %>uk-grid-divider<% end_if %> <% if $matchHeight %>uk-grid-match<% end_if %>" <% if CollapsableChildren %>data-uk-accordion="content:.uk-panel;toggle:h3;<% if not Collapsable %>collapsible:false;<% end_if %><% if CollapseMultipe %>multiple:true;<% end_if %>"<% end_if %> data-uk-grid data-listelement-count="$Elements.Elements.Count" data-element-expanded="$ExpandedBlocks" >
    $Elements
</div>