$range = $('#range_paid')
$range_labels = $('label[for=range_paid] span')

$range_labels.click ->
  $range
    .val($(@).data 'value')
    .trigger('change')

selectedRange = ->
  $range_labels
  .removeClass('selected')
  .filter("[data-value=#{@value}]")
  .addClass('selected')
selectedRange.apply $range[0]
$range.change selectedRange
