<div class="container">
  <div class="row justify-content-center my-5">
    <div class="col-md-8">
      <h2>Media segment</h2>
      <hr>
      <p>To overwrite this template, create individual file in your theme</p>
      <div class="mb-3"><code>/templates/Partials/Media/{$Type}.ss</code></div>
      <div class="mb-2"><strong>ID:</strong> $ID</div>
      <div class="mb-2"><strong>Type:</strong> $Type</div>
      <div class="mb-2"><strong>Parameters (json):</strong> $Parameters</div>
      <% if $getSegmentTypeConfig('image') %>
        <div class="mb-2"><strong>(config param) Image:</strong> true</div>
        $Image.FitMax(300,150)
      <% end_if %>
      <% if $getSegmentTypeConfig('images') %>
        <div class="mb-2"><strong>(config param) Images:</strong> true</div>
        <% loop Images %>
          $FitMax(300,150)
        <% end_loop %>
      <% end_if %>
      <% loop $ViewJson($Parameters) %>
        <%-- ... --%>
      <% end_loop %>
    </div>
  </div>
</div>
