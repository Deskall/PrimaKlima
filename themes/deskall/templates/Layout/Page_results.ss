

<section class="content-holder">
  <div class="container">
    <div class="col l-1 w-8">
      <h1>$Title</h1>

        <div class="lead-block text-block clearfix">
            <div class="lead">
              <p ><%t SearchPage.QUERY 'Sie suchten nach' %> &quot;{$Query}&quot;</p>
            </div>
        </div>

      
        <% if $Results %>

           <% loop $Results %>

            <div class="blocks clearfix bottom-border">
                <div class="text-block clearfix">
                    <h3><% if $MenuTitle %>$MenuTitle<% else %><% if $Title %>$Title<% else %>$Parent.MenuTitle<% end_if %><% end_if %></h3>
                    <p>$Content.LimitWordCountXML</p>
                   <a href="$Link" class="link-more">Zur Seite «<% if $MenuTitle %>$MenuTitle<% else %><% if $Parent.MenuTitle %>$Parent.MenuTitle<% else %>$Title<% end_if %><% end_if %>» <% include DefaultIcon %></a>
                </div>

            </div>


            <% end_loop %>
        <% else %>
            <div class="blocks clearfix">
                <div class="text-block clearfix">
                    <p><%t SearchPage.NORESULT 'Ihre Suche ergab keine Treffer' %>.</p>
                </div>

            </div>
        <% end_if %>





    <% if $Results.MoreThanOnePage %>
        <div class="blocks clearfix">
            <div class="text-block pagination-holder clearfix">


        <% if $Results.NotLastPage %>
        <a class="next" href="$Results.NextLink" ><%t SearchPage.NEXT 'Weiter' %> <% include DefaultIcon %></a>
        <% end_if %>
        <% if $Results.NotFirstPage %>
        <a class="prev" href="$Results.PrevLink" ><i class="icon icon-arrow-left-b"></i> <%t SearchPage.PREV 'Zurück' %></a>
        <% end_if %>
        <p class="pagination-pages">
            <% loop $Results.Pages %>
                <% if $CurrentBool %>
                $PageNum
                <% else %>
                <a href="$Link" title="View page number $PageNum">$PageNum</a>
                <% end_if %>
            <% end_loop %>
        </p>
            </div>
        </div>
    <% end_if %>





    </div>



      <% include NavigationSidebar %>

  </div>
</section>













