<p class="uk-article-meta uk-padding-small">
    <i data-uk-icon="icon: pencil; ratio: 2;"></i>
<%t SilverStripe\\Blog\\Model\\Blog.Posted "Posted" %>
<a href="$MonthlyArchiveLink">$PublishDate.Nice</a>

<% if $Credits %>
    <%t SilverStripe\\Blog\\Model\\Blog.By "by" %>

    <% loop $Credits %>
        <% if not $First && not $Last %>, <% end_if %>
        <% if not $First && $Last %> <%t SilverStripe\\Blog\\Model\\Blog.AND "and" %> <% end_if %>
        <% if $URLSegment && not $Up.ProfilesDisabled %>
            <a href="$URL">$Name.XML</a>
        <% else %>
            $Name.XML
        <% end_if %>
    <% end_loop %>
<% end_if %>
</p>