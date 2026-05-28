
// 2021-09-05 jj5 - this is the Mudball JavaScript library...

function mud_duplicate_row( el, ev ) {

  const row = el.closest( 'tr' );

  // clone the row
  const copy = row.cloneNode( true );

  // clear inputs in the copied row
  copy.querySelectorAll('input, select, textarea').forEach(el => {

    if (el.tagName === 'SELECT') {

      el.selectedIndex = 0; // or -1 for no selection

    }
    else if (el.type === 'checkbox' || el.type === 'radio') {

      el.checked = false;

    }
    else if ( el.type === 'hidden' ) {

      // 2026-05-28 jj5 - for now we assume that all hidden inputs in a duplicated row are client_id fields, and we assign
      // them new client ids...

      el.value = mud_new_client_id();

    }
    else {

      el.value = '';

    }

  });

  // insert underneath
  row.parentNode.insertBefore( copy, row.nextSibling );

}

function mud_remove_row( el, ev ) {

  const row = el.closest( 'tr' );
  const tbody = row.closest( 'tbody' );
  const rows = tbody.querySelectorAll( 'tr' );

  if ( rows.length <= 1 ) {

    alert( 'Cannot delete the last row.' );

    return;

  }

  row.parentNode.removeChild( row );

}

function mud_new_client_id() {

  window.g_mud_client_id--;

  return window.g_mud_client_id;

}
