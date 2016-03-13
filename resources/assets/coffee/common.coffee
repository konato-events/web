$('#btn-search-toggle').click ->
  $('#header-search-wrapper')
    .toggleClass('display')
    .find('input').focus()
