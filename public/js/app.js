(function() {
  var $range, $range_labels, selectedRange;

  $range = $('#range_paid');

  $range_labels = $('label[for=range_paid] span');

  $range_labels.click(function() {
    return $range.val($(this).data('value')).trigger('change');
  });

  selectedRange = function() {
    return $range_labels.removeClass('selected').filter("[data-value=" + this.value + "]").addClass('selected');
  };

  selectedRange.apply($range[0]);

  $range.change(selectedRange);

}).call(this);

//# sourceMappingURL=app.js.map