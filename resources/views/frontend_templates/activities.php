<script id="activities-template" type="text/x-handlebars-template">
  {{#if activities}}
  <table>
  	<thead>
      <tr>
        <th>Title</th>
        <th>Cell</th>
        <th>Remove</th>
      </tr>
    </thead>
    <tbody>
      {{#each activities}}
      <tr>
        <td>{{title}}</td>
        <td>{{cell}}</td>
        <td>
        	<button class="warning delete" data-index="{{@key}}">delete</button>
        </td>
      </tr>
      {{/each}}
    </tbody>
  </table>
  <button type="button" id="done" class="next success">Done</button>
  {{/if}}
</script>   