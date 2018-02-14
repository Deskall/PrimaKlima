<div class="elemental-preview">
    <a href="$CMSEditLink" class="elemental-edit">
     
        <div class="elemental-preview__detail">
            <h3><% if Title %>$Title <% end_if %></h3>
                 <% loop $activeLinks %>
                        $forTemplate
                    <% end_loop %>
        </div>
    </a>
</div>
