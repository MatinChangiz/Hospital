var config = {
  '.chosen-select'           : {},
  '.chosen-select-deselect'  : { allow_single_deselect: true },
  '.chosen-select-no-single' : { disable_search_threshold: 10 },
  '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
  '.chosen-select-rtl'       : { rtl: true },
  '.chosen-select-rtl1'       : { rtl: true },
  '.chosen-select-rtl2'       : { rtl: true },
  '.chosen-select-rtl3'       : { rtl: true },
  '.chosen-select-rtl4'       : { rtl: true },
  '.chosen-select-rtl5'       : { rtl: true },
  '.chosen-select-rtl6'       : { rtl: true },
  '.chosen-select-rtl7'       : { rtl: true },
  '.chosen-select-rtl8'       : { rtl: true },
  '.chosen-select-rtl9'       : { rtl: true },
  '.chosen-select-rtl10'       : { rtl: true },
  '.chosen-select-rtl11'       : { rtl: true },
  '.chosen-select-rtl12'       : { rtl: true },
  '.chosen-select-rtl13'       : { rtl: true },
  '.chosen-select-rtl14'       : { rtl: true },
  '.chosen-select-rtl15'       : { rtl: true },
  '.chosen-select-width'     : { width: '95%' }
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}
