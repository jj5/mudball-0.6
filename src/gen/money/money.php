<?php


class MudCurrency_AED extends MudCurrency {

  public function get_currency_code() : string { return 'AED'; }

  public function get_currency_code_numeric() : int { return 784; }

  public function get_currency_name() : string { return "UAE Dirham"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_AED extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'AED' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'AED'; }

  public function get_currency_code_numeric() : int { return 784; }

  public function get_currency_name() : string { return "UAE Dirham"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_AFN extends MudCurrency {

  public function get_currency_code() : string { return 'AFN'; }

  public function get_currency_code_numeric() : int { return 971; }

  public function get_currency_name() : string { return "Afghani"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_AFN extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'AFN' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'AFN'; }

  public function get_currency_code_numeric() : int { return 971; }

  public function get_currency_name() : string { return "Afghani"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_ALL extends MudCurrency {

  public function get_currency_code() : string { return 'ALL'; }

  public function get_currency_code_numeric() : int { return 8; }

  public function get_currency_name() : string { return "Lek"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_ALL extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'ALL' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'ALL'; }

  public function get_currency_code_numeric() : int { return 8; }

  public function get_currency_name() : string { return "Lek"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_AMD extends MudCurrency {

  public function get_currency_code() : string { return 'AMD'; }

  public function get_currency_code_numeric() : int { return 51; }

  public function get_currency_name() : string { return "Armenian Dram"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_AMD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'AMD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'AMD'; }

  public function get_currency_code_numeric() : int { return 51; }

  public function get_currency_name() : string { return "Armenian Dram"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_ANG extends MudCurrency {

  public function get_currency_code() : string { return 'ANG'; }

  public function get_currency_code_numeric() : int { return 532; }

  public function get_currency_name() : string { return "Netherlands Antillean Guilder"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_ANG extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'ANG' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'ANG'; }

  public function get_currency_code_numeric() : int { return 532; }

  public function get_currency_name() : string { return "Netherlands Antillean Guilder"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_AOA extends MudCurrency {

  public function get_currency_code() : string { return 'AOA'; }

  public function get_currency_code_numeric() : int { return 973; }

  public function get_currency_name() : string { return "Kwanza"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_AOA extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'AOA' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'AOA'; }

  public function get_currency_code_numeric() : int { return 973; }

  public function get_currency_name() : string { return "Kwanza"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_ARS extends MudCurrency {

  public function get_currency_code() : string { return 'ARS'; }

  public function get_currency_code_numeric() : int { return 32; }

  public function get_currency_name() : string { return "Argentine Peso"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_ARS extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'ARS' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'ARS'; }

  public function get_currency_code_numeric() : int { return 32; }

  public function get_currency_name() : string { return "Argentine Peso"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_AUD extends MudCurrency {

  public function get_currency_code() : string { return 'AUD'; }

  public function get_currency_code_numeric() : int { return 36; }

  public function get_currency_name() : string { return "Australian Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_AUD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'AUD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'AUD'; }

  public function get_currency_code_numeric() : int { return 36; }

  public function get_currency_name() : string { return "Australian Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_AWG extends MudCurrency {

  public function get_currency_code() : string { return 'AWG'; }

  public function get_currency_code_numeric() : int { return 533; }

  public function get_currency_name() : string { return "Aruban Florin"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_AWG extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'AWG' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'AWG'; }

  public function get_currency_code_numeric() : int { return 533; }

  public function get_currency_name() : string { return "Aruban Florin"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_AZN extends MudCurrency {

  public function get_currency_code() : string { return 'AZN'; }

  public function get_currency_code_numeric() : int { return 944; }

  public function get_currency_name() : string { return "Azerbaijan Manat"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_AZN extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'AZN' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'AZN'; }

  public function get_currency_code_numeric() : int { return 944; }

  public function get_currency_name() : string { return "Azerbaijan Manat"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_BAM extends MudCurrency {

  public function get_currency_code() : string { return 'BAM'; }

  public function get_currency_code_numeric() : int { return 977; }

  public function get_currency_name() : string { return "Convertible Mark"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_BAM extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'BAM' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'BAM'; }

  public function get_currency_code_numeric() : int { return 977; }

  public function get_currency_name() : string { return "Convertible Mark"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_BBD extends MudCurrency {

  public function get_currency_code() : string { return 'BBD'; }

  public function get_currency_code_numeric() : int { return 52; }

  public function get_currency_name() : string { return "Barbados Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_BBD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'BBD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'BBD'; }

  public function get_currency_code_numeric() : int { return 52; }

  public function get_currency_name() : string { return "Barbados Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_BDT extends MudCurrency {

  public function get_currency_code() : string { return 'BDT'; }

  public function get_currency_code_numeric() : int { return 50; }

  public function get_currency_name() : string { return "Taka"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_BDT extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'BDT' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'BDT'; }

  public function get_currency_code_numeric() : int { return 50; }

  public function get_currency_name() : string { return "Taka"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_BGN extends MudCurrency {

  public function get_currency_code() : string { return 'BGN'; }

  public function get_currency_code_numeric() : int { return 975; }

  public function get_currency_name() : string { return "Bulgarian Lev"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_BGN extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'BGN' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'BGN'; }

  public function get_currency_code_numeric() : int { return 975; }

  public function get_currency_name() : string { return "Bulgarian Lev"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_BHD extends MudCurrency {

  public function get_currency_code() : string { return 'BHD'; }

  public function get_currency_code_numeric() : int { return 48; }

  public function get_currency_name() : string { return "Bahraini Dinar"; }

  public function get_currency_minor_unit() : int { return 3; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_BHD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'BHD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'BHD'; }

  public function get_currency_code_numeric() : int { return 48; }

  public function get_currency_name() : string { return "Bahraini Dinar"; }

  public function get_currency_minor_unit() : int { return 3; }

}


class MudCurrency_BIF extends MudCurrency {

  public function get_currency_code() : string { return 'BIF'; }

  public function get_currency_code_numeric() : int { return 108; }

  public function get_currency_name() : string { return "Burundi Franc"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_BIF extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'BIF' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'BIF'; }

  public function get_currency_code_numeric() : int { return 108; }

  public function get_currency_name() : string { return "Burundi Franc"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_BMD extends MudCurrency {

  public function get_currency_code() : string { return 'BMD'; }

  public function get_currency_code_numeric() : int { return 60; }

  public function get_currency_name() : string { return "Bermudian Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_BMD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'BMD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'BMD'; }

  public function get_currency_code_numeric() : int { return 60; }

  public function get_currency_name() : string { return "Bermudian Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_BND extends MudCurrency {

  public function get_currency_code() : string { return 'BND'; }

  public function get_currency_code_numeric() : int { return 96; }

  public function get_currency_name() : string { return "Brunei Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_BND extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'BND' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'BND'; }

  public function get_currency_code_numeric() : int { return 96; }

  public function get_currency_name() : string { return "Brunei Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_BOB extends MudCurrency {

  public function get_currency_code() : string { return 'BOB'; }

  public function get_currency_code_numeric() : int { return 68; }

  public function get_currency_name() : string { return "Boliviano"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_BOB extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'BOB' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'BOB'; }

  public function get_currency_code_numeric() : int { return 68; }

  public function get_currency_name() : string { return "Boliviano"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_BOV extends MudCurrency {

  public function get_currency_code() : string { return 'BOV'; }

  public function get_currency_code_numeric() : int { return 984; }

  public function get_currency_name() : string { return "Mvdol"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_BOV extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'BOV' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'BOV'; }

  public function get_currency_code_numeric() : int { return 984; }

  public function get_currency_name() : string { return "Mvdol"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_BRL extends MudCurrency {

  public function get_currency_code() : string { return 'BRL'; }

  public function get_currency_code_numeric() : int { return 986; }

  public function get_currency_name() : string { return "Brazilian Real"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_BRL extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'BRL' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'BRL'; }

  public function get_currency_code_numeric() : int { return 986; }

  public function get_currency_name() : string { return "Brazilian Real"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_BSD extends MudCurrency {

  public function get_currency_code() : string { return 'BSD'; }

  public function get_currency_code_numeric() : int { return 44; }

  public function get_currency_name() : string { return "Bahamian Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_BSD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'BSD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'BSD'; }

  public function get_currency_code_numeric() : int { return 44; }

  public function get_currency_name() : string { return "Bahamian Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_BTN extends MudCurrency {

  public function get_currency_code() : string { return 'BTN'; }

  public function get_currency_code_numeric() : int { return 64; }

  public function get_currency_name() : string { return "Ngultrum"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_BTN extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'BTN' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'BTN'; }

  public function get_currency_code_numeric() : int { return 64; }

  public function get_currency_name() : string { return "Ngultrum"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_BWP extends MudCurrency {

  public function get_currency_code() : string { return 'BWP'; }

  public function get_currency_code_numeric() : int { return 72; }

  public function get_currency_name() : string { return "Pula"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_BWP extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'BWP' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'BWP'; }

  public function get_currency_code_numeric() : int { return 72; }

  public function get_currency_name() : string { return "Pula"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_BYN extends MudCurrency {

  public function get_currency_code() : string { return 'BYN'; }

  public function get_currency_code_numeric() : int { return 933; }

  public function get_currency_name() : string { return "Belarusian Ruble"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_BYN extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'BYN' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'BYN'; }

  public function get_currency_code_numeric() : int { return 933; }

  public function get_currency_name() : string { return "Belarusian Ruble"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_BZD extends MudCurrency {

  public function get_currency_code() : string { return 'BZD'; }

  public function get_currency_code_numeric() : int { return 84; }

  public function get_currency_name() : string { return "Belize Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_BZD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'BZD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'BZD'; }

  public function get_currency_code_numeric() : int { return 84; }

  public function get_currency_name() : string { return "Belize Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_CAD extends MudCurrency {

  public function get_currency_code() : string { return 'CAD'; }

  public function get_currency_code_numeric() : int { return 124; }

  public function get_currency_name() : string { return "Canadian Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_CAD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'CAD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'CAD'; }

  public function get_currency_code_numeric() : int { return 124; }

  public function get_currency_name() : string { return "Canadian Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_CDF extends MudCurrency {

  public function get_currency_code() : string { return 'CDF'; }

  public function get_currency_code_numeric() : int { return 976; }

  public function get_currency_name() : string { return "Congolese Franc"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_CDF extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'CDF' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'CDF'; }

  public function get_currency_code_numeric() : int { return 976; }

  public function get_currency_name() : string { return "Congolese Franc"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_CHE extends MudCurrency {

  public function get_currency_code() : string { return 'CHE'; }

  public function get_currency_code_numeric() : int { return 947; }

  public function get_currency_name() : string { return "WIR Euro"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_CHE extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'CHE' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'CHE'; }

  public function get_currency_code_numeric() : int { return 947; }

  public function get_currency_name() : string { return "WIR Euro"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_CHF extends MudCurrency {

  public function get_currency_code() : string { return 'CHF'; }

  public function get_currency_code_numeric() : int { return 756; }

  public function get_currency_name() : string { return "Swiss Franc"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_CHF extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'CHF' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'CHF'; }

  public function get_currency_code_numeric() : int { return 756; }

  public function get_currency_name() : string { return "Swiss Franc"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_CHW extends MudCurrency {

  public function get_currency_code() : string { return 'CHW'; }

  public function get_currency_code_numeric() : int { return 948; }

  public function get_currency_name() : string { return "WIR Franc"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_CHW extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'CHW' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'CHW'; }

  public function get_currency_code_numeric() : int { return 948; }

  public function get_currency_name() : string { return "WIR Franc"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_CLF extends MudCurrency {

  public function get_currency_code() : string { return 'CLF'; }

  public function get_currency_code_numeric() : int { return 990; }

  public function get_currency_name() : string { return "Unidad de Fomento"; }

  public function get_currency_minor_unit() : int { return 4; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_CLF extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'CLF' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'CLF'; }

  public function get_currency_code_numeric() : int { return 990; }

  public function get_currency_name() : string { return "Unidad de Fomento"; }

  public function get_currency_minor_unit() : int { return 4; }

}


class MudCurrency_CLP extends MudCurrency {

  public function get_currency_code() : string { return 'CLP'; }

  public function get_currency_code_numeric() : int { return 152; }

  public function get_currency_name() : string { return "Chilean Peso"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_CLP extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'CLP' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'CLP'; }

  public function get_currency_code_numeric() : int { return 152; }

  public function get_currency_name() : string { return "Chilean Peso"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_CNY extends MudCurrency {

  public function get_currency_code() : string { return 'CNY'; }

  public function get_currency_code_numeric() : int { return 156; }

  public function get_currency_name() : string { return "Yuan Renminbi"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_CNY extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'CNY' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'CNY'; }

  public function get_currency_code_numeric() : int { return 156; }

  public function get_currency_name() : string { return "Yuan Renminbi"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_COP extends MudCurrency {

  public function get_currency_code() : string { return 'COP'; }

  public function get_currency_code_numeric() : int { return 170; }

  public function get_currency_name() : string { return "Colombian Peso"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_COP extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'COP' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'COP'; }

  public function get_currency_code_numeric() : int { return 170; }

  public function get_currency_name() : string { return "Colombian Peso"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_COU extends MudCurrency {

  public function get_currency_code() : string { return 'COU'; }

  public function get_currency_code_numeric() : int { return 970; }

  public function get_currency_name() : string { return "Unidad de Valor Real"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_COU extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'COU' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'COU'; }

  public function get_currency_code_numeric() : int { return 970; }

  public function get_currency_name() : string { return "Unidad de Valor Real"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_CRC extends MudCurrency {

  public function get_currency_code() : string { return 'CRC'; }

  public function get_currency_code_numeric() : int { return 188; }

  public function get_currency_name() : string { return "Costa Rican Colon"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_CRC extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'CRC' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'CRC'; }

  public function get_currency_code_numeric() : int { return 188; }

  public function get_currency_name() : string { return "Costa Rican Colon"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_CUC extends MudCurrency {

  public function get_currency_code() : string { return 'CUC'; }

  public function get_currency_code_numeric() : int { return 931; }

  public function get_currency_name() : string { return "Peso Convertible"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_CUC extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'CUC' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'CUC'; }

  public function get_currency_code_numeric() : int { return 931; }

  public function get_currency_name() : string { return "Peso Convertible"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_CUP extends MudCurrency {

  public function get_currency_code() : string { return 'CUP'; }

  public function get_currency_code_numeric() : int { return 192; }

  public function get_currency_name() : string { return "Cuban Peso"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_CUP extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'CUP' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'CUP'; }

  public function get_currency_code_numeric() : int { return 192; }

  public function get_currency_name() : string { return "Cuban Peso"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_CVE extends MudCurrency {

  public function get_currency_code() : string { return 'CVE'; }

  public function get_currency_code_numeric() : int { return 132; }

  public function get_currency_name() : string { return "Cabo Verde Escudo"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_CVE extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'CVE' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'CVE'; }

  public function get_currency_code_numeric() : int { return 132; }

  public function get_currency_name() : string { return "Cabo Verde Escudo"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_CZK extends MudCurrency {

  public function get_currency_code() : string { return 'CZK'; }

  public function get_currency_code_numeric() : int { return 203; }

  public function get_currency_name() : string { return "Czech Koruna"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_CZK extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'CZK' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'CZK'; }

  public function get_currency_code_numeric() : int { return 203; }

  public function get_currency_name() : string { return "Czech Koruna"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_DJF extends MudCurrency {

  public function get_currency_code() : string { return 'DJF'; }

  public function get_currency_code_numeric() : int { return 262; }

  public function get_currency_name() : string { return "Djibouti Franc"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_DJF extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'DJF' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'DJF'; }

  public function get_currency_code_numeric() : int { return 262; }

  public function get_currency_name() : string { return "Djibouti Franc"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_DKK extends MudCurrency {

  public function get_currency_code() : string { return 'DKK'; }

  public function get_currency_code_numeric() : int { return 208; }

  public function get_currency_name() : string { return "Danish Krone"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_DKK extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'DKK' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'DKK'; }

  public function get_currency_code_numeric() : int { return 208; }

  public function get_currency_name() : string { return "Danish Krone"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_DOP extends MudCurrency {

  public function get_currency_code() : string { return 'DOP'; }

  public function get_currency_code_numeric() : int { return 214; }

  public function get_currency_name() : string { return "Dominican Peso"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_DOP extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'DOP' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'DOP'; }

  public function get_currency_code_numeric() : int { return 214; }

  public function get_currency_name() : string { return "Dominican Peso"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_DZD extends MudCurrency {

  public function get_currency_code() : string { return 'DZD'; }

  public function get_currency_code_numeric() : int { return 12; }

  public function get_currency_name() : string { return "Algerian Dinar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_DZD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'DZD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'DZD'; }

  public function get_currency_code_numeric() : int { return 12; }

  public function get_currency_name() : string { return "Algerian Dinar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_EGP extends MudCurrency {

  public function get_currency_code() : string { return 'EGP'; }

  public function get_currency_code_numeric() : int { return 818; }

  public function get_currency_name() : string { return "Egyptian Pound"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_EGP extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'EGP' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'EGP'; }

  public function get_currency_code_numeric() : int { return 818; }

  public function get_currency_name() : string { return "Egyptian Pound"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_ERN extends MudCurrency {

  public function get_currency_code() : string { return 'ERN'; }

  public function get_currency_code_numeric() : int { return 232; }

  public function get_currency_name() : string { return "Nakfa"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_ERN extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'ERN' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'ERN'; }

  public function get_currency_code_numeric() : int { return 232; }

  public function get_currency_name() : string { return "Nakfa"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_ETB extends MudCurrency {

  public function get_currency_code() : string { return 'ETB'; }

  public function get_currency_code_numeric() : int { return 230; }

  public function get_currency_name() : string { return "Ethiopian Birr"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_ETB extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'ETB' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'ETB'; }

  public function get_currency_code_numeric() : int { return 230; }

  public function get_currency_name() : string { return "Ethiopian Birr"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_EUR extends MudCurrency {

  public function get_currency_code() : string { return 'EUR'; }

  public function get_currency_code_numeric() : int { return 978; }

  public function get_currency_name() : string { return "Euro"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_EUR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'EUR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'EUR'; }

  public function get_currency_code_numeric() : int { return 978; }

  public function get_currency_name() : string { return "Euro"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_FJD extends MudCurrency {

  public function get_currency_code() : string { return 'FJD'; }

  public function get_currency_code_numeric() : int { return 242; }

  public function get_currency_name() : string { return "Fiji Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_FJD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'FJD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'FJD'; }

  public function get_currency_code_numeric() : int { return 242; }

  public function get_currency_name() : string { return "Fiji Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_FKP extends MudCurrency {

  public function get_currency_code() : string { return 'FKP'; }

  public function get_currency_code_numeric() : int { return 238; }

  public function get_currency_name() : string { return "Falkland Islands Pound"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_FKP extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'FKP' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'FKP'; }

  public function get_currency_code_numeric() : int { return 238; }

  public function get_currency_name() : string { return "Falkland Islands Pound"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_GBP extends MudCurrency {

  public function get_currency_code() : string { return 'GBP'; }

  public function get_currency_code_numeric() : int { return 826; }

  public function get_currency_name() : string { return "Pound Sterling"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_GBP extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'GBP' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'GBP'; }

  public function get_currency_code_numeric() : int { return 826; }

  public function get_currency_name() : string { return "Pound Sterling"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_GEL extends MudCurrency {

  public function get_currency_code() : string { return 'GEL'; }

  public function get_currency_code_numeric() : int { return 981; }

  public function get_currency_name() : string { return "Lari"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_GEL extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'GEL' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'GEL'; }

  public function get_currency_code_numeric() : int { return 981; }

  public function get_currency_name() : string { return "Lari"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_GHS extends MudCurrency {

  public function get_currency_code() : string { return 'GHS'; }

  public function get_currency_code_numeric() : int { return 936; }

  public function get_currency_name() : string { return "Ghana Cedi"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_GHS extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'GHS' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'GHS'; }

  public function get_currency_code_numeric() : int { return 936; }

  public function get_currency_name() : string { return "Ghana Cedi"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_GIP extends MudCurrency {

  public function get_currency_code() : string { return 'GIP'; }

  public function get_currency_code_numeric() : int { return 292; }

  public function get_currency_name() : string { return "Gibraltar Pound"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_GIP extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'GIP' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'GIP'; }

  public function get_currency_code_numeric() : int { return 292; }

  public function get_currency_name() : string { return "Gibraltar Pound"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_GMD extends MudCurrency {

  public function get_currency_code() : string { return 'GMD'; }

  public function get_currency_code_numeric() : int { return 270; }

  public function get_currency_name() : string { return "Dalasi"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_GMD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'GMD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'GMD'; }

  public function get_currency_code_numeric() : int { return 270; }

  public function get_currency_name() : string { return "Dalasi"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_GNF extends MudCurrency {

  public function get_currency_code() : string { return 'GNF'; }

  public function get_currency_code_numeric() : int { return 324; }

  public function get_currency_name() : string { return "Guinean Franc"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_GNF extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'GNF' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'GNF'; }

  public function get_currency_code_numeric() : int { return 324; }

  public function get_currency_name() : string { return "Guinean Franc"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_GTQ extends MudCurrency {

  public function get_currency_code() : string { return 'GTQ'; }

  public function get_currency_code_numeric() : int { return 320; }

  public function get_currency_name() : string { return "Quetzal"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_GTQ extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'GTQ' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'GTQ'; }

  public function get_currency_code_numeric() : int { return 320; }

  public function get_currency_name() : string { return "Quetzal"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_GYD extends MudCurrency {

  public function get_currency_code() : string { return 'GYD'; }

  public function get_currency_code_numeric() : int { return 328; }

  public function get_currency_name() : string { return "Guyana Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_GYD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'GYD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'GYD'; }

  public function get_currency_code_numeric() : int { return 328; }

  public function get_currency_name() : string { return "Guyana Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_HKD extends MudCurrency {

  public function get_currency_code() : string { return 'HKD'; }

  public function get_currency_code_numeric() : int { return 344; }

  public function get_currency_name() : string { return "Hong Kong Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_HKD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'HKD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'HKD'; }

  public function get_currency_code_numeric() : int { return 344; }

  public function get_currency_name() : string { return "Hong Kong Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_HNL extends MudCurrency {

  public function get_currency_code() : string { return 'HNL'; }

  public function get_currency_code_numeric() : int { return 340; }

  public function get_currency_name() : string { return "Lempira"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_HNL extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'HNL' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'HNL'; }

  public function get_currency_code_numeric() : int { return 340; }

  public function get_currency_name() : string { return "Lempira"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_HTG extends MudCurrency {

  public function get_currency_code() : string { return 'HTG'; }

  public function get_currency_code_numeric() : int { return 332; }

  public function get_currency_name() : string { return "Gourde"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_HTG extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'HTG' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'HTG'; }

  public function get_currency_code_numeric() : int { return 332; }

  public function get_currency_name() : string { return "Gourde"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_HUF extends MudCurrency {

  public function get_currency_code() : string { return 'HUF'; }

  public function get_currency_code_numeric() : int { return 348; }

  public function get_currency_name() : string { return "Forint"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_HUF extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'HUF' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'HUF'; }

  public function get_currency_code_numeric() : int { return 348; }

  public function get_currency_name() : string { return "Forint"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_IDR extends MudCurrency {

  public function get_currency_code() : string { return 'IDR'; }

  public function get_currency_code_numeric() : int { return 360; }

  public function get_currency_name() : string { return "Rupiah"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_IDR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'IDR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'IDR'; }

  public function get_currency_code_numeric() : int { return 360; }

  public function get_currency_name() : string { return "Rupiah"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_ILS extends MudCurrency {

  public function get_currency_code() : string { return 'ILS'; }

  public function get_currency_code_numeric() : int { return 376; }

  public function get_currency_name() : string { return "New Israeli Sheqel"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_ILS extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'ILS' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'ILS'; }

  public function get_currency_code_numeric() : int { return 376; }

  public function get_currency_name() : string { return "New Israeli Sheqel"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_INR extends MudCurrency {

  public function get_currency_code() : string { return 'INR'; }

  public function get_currency_code_numeric() : int { return 356; }

  public function get_currency_name() : string { return "Indian Rupee"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_INR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'INR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'INR'; }

  public function get_currency_code_numeric() : int { return 356; }

  public function get_currency_name() : string { return "Indian Rupee"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_IQD extends MudCurrency {

  public function get_currency_code() : string { return 'IQD'; }

  public function get_currency_code_numeric() : int { return 368; }

  public function get_currency_name() : string { return "Iraqi Dinar"; }

  public function get_currency_minor_unit() : int { return 3; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_IQD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'IQD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'IQD'; }

  public function get_currency_code_numeric() : int { return 368; }

  public function get_currency_name() : string { return "Iraqi Dinar"; }

  public function get_currency_minor_unit() : int { return 3; }

}


class MudCurrency_IRR extends MudCurrency {

  public function get_currency_code() : string { return 'IRR'; }

  public function get_currency_code_numeric() : int { return 364; }

  public function get_currency_name() : string { return "Iranian Rial"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_IRR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'IRR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'IRR'; }

  public function get_currency_code_numeric() : int { return 364; }

  public function get_currency_name() : string { return "Iranian Rial"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_ISK extends MudCurrency {

  public function get_currency_code() : string { return 'ISK'; }

  public function get_currency_code_numeric() : int { return 352; }

  public function get_currency_name() : string { return "Iceland Krona"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_ISK extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'ISK' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'ISK'; }

  public function get_currency_code_numeric() : int { return 352; }

  public function get_currency_name() : string { return "Iceland Krona"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_JMD extends MudCurrency {

  public function get_currency_code() : string { return 'JMD'; }

  public function get_currency_code_numeric() : int { return 388; }

  public function get_currency_name() : string { return "Jamaican Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_JMD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'JMD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'JMD'; }

  public function get_currency_code_numeric() : int { return 388; }

  public function get_currency_name() : string { return "Jamaican Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_JOD extends MudCurrency {

  public function get_currency_code() : string { return 'JOD'; }

  public function get_currency_code_numeric() : int { return 400; }

  public function get_currency_name() : string { return "Jordanian Dinar"; }

  public function get_currency_minor_unit() : int { return 3; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_JOD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'JOD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'JOD'; }

  public function get_currency_code_numeric() : int { return 400; }

  public function get_currency_name() : string { return "Jordanian Dinar"; }

  public function get_currency_minor_unit() : int { return 3; }

}


class MudCurrency_JPY extends MudCurrency {

  public function get_currency_code() : string { return 'JPY'; }

  public function get_currency_code_numeric() : int { return 392; }

  public function get_currency_name() : string { return "Yen"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_JPY extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'JPY' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'JPY'; }

  public function get_currency_code_numeric() : int { return 392; }

  public function get_currency_name() : string { return "Yen"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_KES extends MudCurrency {

  public function get_currency_code() : string { return 'KES'; }

  public function get_currency_code_numeric() : int { return 404; }

  public function get_currency_name() : string { return "Kenyan Shilling"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_KES extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'KES' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'KES'; }

  public function get_currency_code_numeric() : int { return 404; }

  public function get_currency_name() : string { return "Kenyan Shilling"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_KGS extends MudCurrency {

  public function get_currency_code() : string { return 'KGS'; }

  public function get_currency_code_numeric() : int { return 417; }

  public function get_currency_name() : string { return "Som"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_KGS extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'KGS' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'KGS'; }

  public function get_currency_code_numeric() : int { return 417; }

  public function get_currency_name() : string { return "Som"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_KHR extends MudCurrency {

  public function get_currency_code() : string { return 'KHR'; }

  public function get_currency_code_numeric() : int { return 116; }

  public function get_currency_name() : string { return "Riel"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_KHR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'KHR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'KHR'; }

  public function get_currency_code_numeric() : int { return 116; }

  public function get_currency_name() : string { return "Riel"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_KMF extends MudCurrency {

  public function get_currency_code() : string { return 'KMF'; }

  public function get_currency_code_numeric() : int { return 174; }

  public function get_currency_name() : string { return "Comorian Franc "; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_KMF extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'KMF' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'KMF'; }

  public function get_currency_code_numeric() : int { return 174; }

  public function get_currency_name() : string { return "Comorian Franc "; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_KPW extends MudCurrency {

  public function get_currency_code() : string { return 'KPW'; }

  public function get_currency_code_numeric() : int { return 408; }

  public function get_currency_name() : string { return "North Korean Won"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_KPW extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'KPW' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'KPW'; }

  public function get_currency_code_numeric() : int { return 408; }

  public function get_currency_name() : string { return "North Korean Won"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_KRW extends MudCurrency {

  public function get_currency_code() : string { return 'KRW'; }

  public function get_currency_code_numeric() : int { return 410; }

  public function get_currency_name() : string { return "Won"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_KRW extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'KRW' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'KRW'; }

  public function get_currency_code_numeric() : int { return 410; }

  public function get_currency_name() : string { return "Won"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_KWD extends MudCurrency {

  public function get_currency_code() : string { return 'KWD'; }

  public function get_currency_code_numeric() : int { return 414; }

  public function get_currency_name() : string { return "Kuwaiti Dinar"; }

  public function get_currency_minor_unit() : int { return 3; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_KWD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'KWD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'KWD'; }

  public function get_currency_code_numeric() : int { return 414; }

  public function get_currency_name() : string { return "Kuwaiti Dinar"; }

  public function get_currency_minor_unit() : int { return 3; }

}


class MudCurrency_KYD extends MudCurrency {

  public function get_currency_code() : string { return 'KYD'; }

  public function get_currency_code_numeric() : int { return 136; }

  public function get_currency_name() : string { return "Cayman Islands Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_KYD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'KYD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'KYD'; }

  public function get_currency_code_numeric() : int { return 136; }

  public function get_currency_name() : string { return "Cayman Islands Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_KZT extends MudCurrency {

  public function get_currency_code() : string { return 'KZT'; }

  public function get_currency_code_numeric() : int { return 398; }

  public function get_currency_name() : string { return "Tenge"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_KZT extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'KZT' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'KZT'; }

  public function get_currency_code_numeric() : int { return 398; }

  public function get_currency_name() : string { return "Tenge"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_LAK extends MudCurrency {

  public function get_currency_code() : string { return 'LAK'; }

  public function get_currency_code_numeric() : int { return 418; }

  public function get_currency_name() : string { return "Lao Kip"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_LAK extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'LAK' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'LAK'; }

  public function get_currency_code_numeric() : int { return 418; }

  public function get_currency_name() : string { return "Lao Kip"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_LBP extends MudCurrency {

  public function get_currency_code() : string { return 'LBP'; }

  public function get_currency_code_numeric() : int { return 422; }

  public function get_currency_name() : string { return "Lebanese Pound"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_LBP extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'LBP' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'LBP'; }

  public function get_currency_code_numeric() : int { return 422; }

  public function get_currency_name() : string { return "Lebanese Pound"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_LKR extends MudCurrency {

  public function get_currency_code() : string { return 'LKR'; }

  public function get_currency_code_numeric() : int { return 144; }

  public function get_currency_name() : string { return "Sri Lanka Rupee"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_LKR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'LKR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'LKR'; }

  public function get_currency_code_numeric() : int { return 144; }

  public function get_currency_name() : string { return "Sri Lanka Rupee"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_LRD extends MudCurrency {

  public function get_currency_code() : string { return 'LRD'; }

  public function get_currency_code_numeric() : int { return 430; }

  public function get_currency_name() : string { return "Liberian Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_LRD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'LRD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'LRD'; }

  public function get_currency_code_numeric() : int { return 430; }

  public function get_currency_name() : string { return "Liberian Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_LSL extends MudCurrency {

  public function get_currency_code() : string { return 'LSL'; }

  public function get_currency_code_numeric() : int { return 426; }

  public function get_currency_name() : string { return "Loti"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_LSL extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'LSL' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'LSL'; }

  public function get_currency_code_numeric() : int { return 426; }

  public function get_currency_name() : string { return "Loti"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_LYD extends MudCurrency {

  public function get_currency_code() : string { return 'LYD'; }

  public function get_currency_code_numeric() : int { return 434; }

  public function get_currency_name() : string { return "Libyan Dinar"; }

  public function get_currency_minor_unit() : int { return 3; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_LYD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'LYD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'LYD'; }

  public function get_currency_code_numeric() : int { return 434; }

  public function get_currency_name() : string { return "Libyan Dinar"; }

  public function get_currency_minor_unit() : int { return 3; }

}


class MudCurrency_MAD extends MudCurrency {

  public function get_currency_code() : string { return 'MAD'; }

  public function get_currency_code_numeric() : int { return 504; }

  public function get_currency_name() : string { return "Moroccan Dirham"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_MAD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'MAD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'MAD'; }

  public function get_currency_code_numeric() : int { return 504; }

  public function get_currency_name() : string { return "Moroccan Dirham"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_MDL extends MudCurrency {

  public function get_currency_code() : string { return 'MDL'; }

  public function get_currency_code_numeric() : int { return 498; }

  public function get_currency_name() : string { return "Moldovan Leu"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_MDL extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'MDL' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'MDL'; }

  public function get_currency_code_numeric() : int { return 498; }

  public function get_currency_name() : string { return "Moldovan Leu"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_MGA extends MudCurrency {

  public function get_currency_code() : string { return 'MGA'; }

  public function get_currency_code_numeric() : int { return 969; }

  public function get_currency_name() : string { return "Malagasy Ariary"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_MGA extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'MGA' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'MGA'; }

  public function get_currency_code_numeric() : int { return 969; }

  public function get_currency_name() : string { return "Malagasy Ariary"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_MKD extends MudCurrency {

  public function get_currency_code() : string { return 'MKD'; }

  public function get_currency_code_numeric() : int { return 807; }

  public function get_currency_name() : string { return "Denar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_MKD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'MKD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'MKD'; }

  public function get_currency_code_numeric() : int { return 807; }

  public function get_currency_name() : string { return "Denar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_MMK extends MudCurrency {

  public function get_currency_code() : string { return 'MMK'; }

  public function get_currency_code_numeric() : int { return 104; }

  public function get_currency_name() : string { return "Kyat"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_MMK extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'MMK' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'MMK'; }

  public function get_currency_code_numeric() : int { return 104; }

  public function get_currency_name() : string { return "Kyat"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_MNT extends MudCurrency {

  public function get_currency_code() : string { return 'MNT'; }

  public function get_currency_code_numeric() : int { return 496; }

  public function get_currency_name() : string { return "Tugrik"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_MNT extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'MNT' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'MNT'; }

  public function get_currency_code_numeric() : int { return 496; }

  public function get_currency_name() : string { return "Tugrik"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_MOP extends MudCurrency {

  public function get_currency_code() : string { return 'MOP'; }

  public function get_currency_code_numeric() : int { return 446; }

  public function get_currency_name() : string { return "Pataca"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_MOP extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'MOP' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'MOP'; }

  public function get_currency_code_numeric() : int { return 446; }

  public function get_currency_name() : string { return "Pataca"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_MRU extends MudCurrency {

  public function get_currency_code() : string { return 'MRU'; }

  public function get_currency_code_numeric() : int { return 929; }

  public function get_currency_name() : string { return "Ouguiya"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_MRU extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'MRU' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'MRU'; }

  public function get_currency_code_numeric() : int { return 929; }

  public function get_currency_name() : string { return "Ouguiya"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_MUR extends MudCurrency {

  public function get_currency_code() : string { return 'MUR'; }

  public function get_currency_code_numeric() : int { return 480; }

  public function get_currency_name() : string { return "Mauritius Rupee"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_MUR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'MUR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'MUR'; }

  public function get_currency_code_numeric() : int { return 480; }

  public function get_currency_name() : string { return "Mauritius Rupee"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_MVR extends MudCurrency {

  public function get_currency_code() : string { return 'MVR'; }

  public function get_currency_code_numeric() : int { return 462; }

  public function get_currency_name() : string { return "Rufiyaa"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_MVR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'MVR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'MVR'; }

  public function get_currency_code_numeric() : int { return 462; }

  public function get_currency_name() : string { return "Rufiyaa"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_MWK extends MudCurrency {

  public function get_currency_code() : string { return 'MWK'; }

  public function get_currency_code_numeric() : int { return 454; }

  public function get_currency_name() : string { return "Malawi Kwacha"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_MWK extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'MWK' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'MWK'; }

  public function get_currency_code_numeric() : int { return 454; }

  public function get_currency_name() : string { return "Malawi Kwacha"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_MXN extends MudCurrency {

  public function get_currency_code() : string { return 'MXN'; }

  public function get_currency_code_numeric() : int { return 484; }

  public function get_currency_name() : string { return "Mexican Peso"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_MXN extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'MXN' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'MXN'; }

  public function get_currency_code_numeric() : int { return 484; }

  public function get_currency_name() : string { return "Mexican Peso"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_MXV extends MudCurrency {

  public function get_currency_code() : string { return 'MXV'; }

  public function get_currency_code_numeric() : int { return 979; }

  public function get_currency_name() : string { return "Mexican Unidad de Inversion (UDI)"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_MXV extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'MXV' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'MXV'; }

  public function get_currency_code_numeric() : int { return 979; }

  public function get_currency_name() : string { return "Mexican Unidad de Inversion (UDI)"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_MYR extends MudCurrency {

  public function get_currency_code() : string { return 'MYR'; }

  public function get_currency_code_numeric() : int { return 458; }

  public function get_currency_name() : string { return "Malaysian Ringgit"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_MYR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'MYR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'MYR'; }

  public function get_currency_code_numeric() : int { return 458; }

  public function get_currency_name() : string { return "Malaysian Ringgit"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_MZN extends MudCurrency {

  public function get_currency_code() : string { return 'MZN'; }

  public function get_currency_code_numeric() : int { return 943; }

  public function get_currency_name() : string { return "Mozambique Metical"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_MZN extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'MZN' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'MZN'; }

  public function get_currency_code_numeric() : int { return 943; }

  public function get_currency_name() : string { return "Mozambique Metical"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_NAD extends MudCurrency {

  public function get_currency_code() : string { return 'NAD'; }

  public function get_currency_code_numeric() : int { return 516; }

  public function get_currency_name() : string { return "Namibia Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_NAD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'NAD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'NAD'; }

  public function get_currency_code_numeric() : int { return 516; }

  public function get_currency_name() : string { return "Namibia Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_NGN extends MudCurrency {

  public function get_currency_code() : string { return 'NGN'; }

  public function get_currency_code_numeric() : int { return 566; }

  public function get_currency_name() : string { return "Naira"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_NGN extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'NGN' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'NGN'; }

  public function get_currency_code_numeric() : int { return 566; }

  public function get_currency_name() : string { return "Naira"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_NIO extends MudCurrency {

  public function get_currency_code() : string { return 'NIO'; }

  public function get_currency_code_numeric() : int { return 558; }

  public function get_currency_name() : string { return "Cordoba Oro"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_NIO extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'NIO' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'NIO'; }

  public function get_currency_code_numeric() : int { return 558; }

  public function get_currency_name() : string { return "Cordoba Oro"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_NOK extends MudCurrency {

  public function get_currency_code() : string { return 'NOK'; }

  public function get_currency_code_numeric() : int { return 578; }

  public function get_currency_name() : string { return "Norwegian Krone"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_NOK extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'NOK' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'NOK'; }

  public function get_currency_code_numeric() : int { return 578; }

  public function get_currency_name() : string { return "Norwegian Krone"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_NPR extends MudCurrency {

  public function get_currency_code() : string { return 'NPR'; }

  public function get_currency_code_numeric() : int { return 524; }

  public function get_currency_name() : string { return "Nepalese Rupee"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_NPR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'NPR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'NPR'; }

  public function get_currency_code_numeric() : int { return 524; }

  public function get_currency_name() : string { return "Nepalese Rupee"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_NZD extends MudCurrency {

  public function get_currency_code() : string { return 'NZD'; }

  public function get_currency_code_numeric() : int { return 554; }

  public function get_currency_name() : string { return "New Zealand Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_NZD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'NZD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'NZD'; }

  public function get_currency_code_numeric() : int { return 554; }

  public function get_currency_name() : string { return "New Zealand Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_OMR extends MudCurrency {

  public function get_currency_code() : string { return 'OMR'; }

  public function get_currency_code_numeric() : int { return 512; }

  public function get_currency_name() : string { return "Rial Omani"; }

  public function get_currency_minor_unit() : int { return 3; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_OMR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'OMR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'OMR'; }

  public function get_currency_code_numeric() : int { return 512; }

  public function get_currency_name() : string { return "Rial Omani"; }

  public function get_currency_minor_unit() : int { return 3; }

}


class MudCurrency_PAB extends MudCurrency {

  public function get_currency_code() : string { return 'PAB'; }

  public function get_currency_code_numeric() : int { return 590; }

  public function get_currency_name() : string { return "Balboa"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_PAB extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'PAB' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'PAB'; }

  public function get_currency_code_numeric() : int { return 590; }

  public function get_currency_name() : string { return "Balboa"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_PEN extends MudCurrency {

  public function get_currency_code() : string { return 'PEN'; }

  public function get_currency_code_numeric() : int { return 604; }

  public function get_currency_name() : string { return "Sol"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_PEN extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'PEN' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'PEN'; }

  public function get_currency_code_numeric() : int { return 604; }

  public function get_currency_name() : string { return "Sol"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_PGK extends MudCurrency {

  public function get_currency_code() : string { return 'PGK'; }

  public function get_currency_code_numeric() : int { return 598; }

  public function get_currency_name() : string { return "Kina"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_PGK extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'PGK' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'PGK'; }

  public function get_currency_code_numeric() : int { return 598; }

  public function get_currency_name() : string { return "Kina"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_PHP extends MudCurrency {

  public function get_currency_code() : string { return 'PHP'; }

  public function get_currency_code_numeric() : int { return 608; }

  public function get_currency_name() : string { return "Philippine Peso"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_PHP extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'PHP' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'PHP'; }

  public function get_currency_code_numeric() : int { return 608; }

  public function get_currency_name() : string { return "Philippine Peso"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_PKR extends MudCurrency {

  public function get_currency_code() : string { return 'PKR'; }

  public function get_currency_code_numeric() : int { return 586; }

  public function get_currency_name() : string { return "Pakistan Rupee"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_PKR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'PKR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'PKR'; }

  public function get_currency_code_numeric() : int { return 586; }

  public function get_currency_name() : string { return "Pakistan Rupee"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_PLN extends MudCurrency {

  public function get_currency_code() : string { return 'PLN'; }

  public function get_currency_code_numeric() : int { return 985; }

  public function get_currency_name() : string { return "Zloty"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_PLN extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'PLN' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'PLN'; }

  public function get_currency_code_numeric() : int { return 985; }

  public function get_currency_name() : string { return "Zloty"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_PYG extends MudCurrency {

  public function get_currency_code() : string { return 'PYG'; }

  public function get_currency_code_numeric() : int { return 600; }

  public function get_currency_name() : string { return "Guarani"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_PYG extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'PYG' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'PYG'; }

  public function get_currency_code_numeric() : int { return 600; }

  public function get_currency_name() : string { return "Guarani"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_QAR extends MudCurrency {

  public function get_currency_code() : string { return 'QAR'; }

  public function get_currency_code_numeric() : int { return 634; }

  public function get_currency_name() : string { return "Qatari Rial"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_QAR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'QAR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'QAR'; }

  public function get_currency_code_numeric() : int { return 634; }

  public function get_currency_name() : string { return "Qatari Rial"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_RON extends MudCurrency {

  public function get_currency_code() : string { return 'RON'; }

  public function get_currency_code_numeric() : int { return 946; }

  public function get_currency_name() : string { return "Romanian Leu"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_RON extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'RON' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'RON'; }

  public function get_currency_code_numeric() : int { return 946; }

  public function get_currency_name() : string { return "Romanian Leu"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_RSD extends MudCurrency {

  public function get_currency_code() : string { return 'RSD'; }

  public function get_currency_code_numeric() : int { return 941; }

  public function get_currency_name() : string { return "Serbian Dinar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_RSD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'RSD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'RSD'; }

  public function get_currency_code_numeric() : int { return 941; }

  public function get_currency_name() : string { return "Serbian Dinar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_RUB extends MudCurrency {

  public function get_currency_code() : string { return 'RUB'; }

  public function get_currency_code_numeric() : int { return 643; }

  public function get_currency_name() : string { return "Russian Ruble"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_RUB extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'RUB' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'RUB'; }

  public function get_currency_code_numeric() : int { return 643; }

  public function get_currency_name() : string { return "Russian Ruble"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_RWF extends MudCurrency {

  public function get_currency_code() : string { return 'RWF'; }

  public function get_currency_code_numeric() : int { return 646; }

  public function get_currency_name() : string { return "Rwanda Franc"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_RWF extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'RWF' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'RWF'; }

  public function get_currency_code_numeric() : int { return 646; }

  public function get_currency_name() : string { return "Rwanda Franc"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_SAR extends MudCurrency {

  public function get_currency_code() : string { return 'SAR'; }

  public function get_currency_code_numeric() : int { return 682; }

  public function get_currency_name() : string { return "Saudi Riyal"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_SAR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'SAR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'SAR'; }

  public function get_currency_code_numeric() : int { return 682; }

  public function get_currency_name() : string { return "Saudi Riyal"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_SBD extends MudCurrency {

  public function get_currency_code() : string { return 'SBD'; }

  public function get_currency_code_numeric() : int { return 90; }

  public function get_currency_name() : string { return "Solomon Islands Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_SBD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'SBD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'SBD'; }

  public function get_currency_code_numeric() : int { return 90; }

  public function get_currency_name() : string { return "Solomon Islands Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_SCR extends MudCurrency {

  public function get_currency_code() : string { return 'SCR'; }

  public function get_currency_code_numeric() : int { return 690; }

  public function get_currency_name() : string { return "Seychelles Rupee"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_SCR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'SCR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'SCR'; }

  public function get_currency_code_numeric() : int { return 690; }

  public function get_currency_name() : string { return "Seychelles Rupee"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_SDG extends MudCurrency {

  public function get_currency_code() : string { return 'SDG'; }

  public function get_currency_code_numeric() : int { return 938; }

  public function get_currency_name() : string { return "Sudanese Pound"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_SDG extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'SDG' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'SDG'; }

  public function get_currency_code_numeric() : int { return 938; }

  public function get_currency_name() : string { return "Sudanese Pound"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_SEK extends MudCurrency {

  public function get_currency_code() : string { return 'SEK'; }

  public function get_currency_code_numeric() : int { return 752; }

  public function get_currency_name() : string { return "Swedish Krona"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_SEK extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'SEK' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'SEK'; }

  public function get_currency_code_numeric() : int { return 752; }

  public function get_currency_name() : string { return "Swedish Krona"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_SGD extends MudCurrency {

  public function get_currency_code() : string { return 'SGD'; }

  public function get_currency_code_numeric() : int { return 702; }

  public function get_currency_name() : string { return "Singapore Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_SGD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'SGD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'SGD'; }

  public function get_currency_code_numeric() : int { return 702; }

  public function get_currency_name() : string { return "Singapore Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_SHP extends MudCurrency {

  public function get_currency_code() : string { return 'SHP'; }

  public function get_currency_code_numeric() : int { return 654; }

  public function get_currency_name() : string { return "Saint Helena Pound"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_SHP extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'SHP' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'SHP'; }

  public function get_currency_code_numeric() : int { return 654; }

  public function get_currency_name() : string { return "Saint Helena Pound"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_SLE extends MudCurrency {

  public function get_currency_code() : string { return 'SLE'; }

  public function get_currency_code_numeric() : int { return 925; }

  public function get_currency_name() : string { return "Leone"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_SLE extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'SLE' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'SLE'; }

  public function get_currency_code_numeric() : int { return 925; }

  public function get_currency_name() : string { return "Leone"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_SOS extends MudCurrency {

  public function get_currency_code() : string { return 'SOS'; }

  public function get_currency_code_numeric() : int { return 706; }

  public function get_currency_name() : string { return "Somali Shilling"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_SOS extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'SOS' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'SOS'; }

  public function get_currency_code_numeric() : int { return 706; }

  public function get_currency_name() : string { return "Somali Shilling"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_SRD extends MudCurrency {

  public function get_currency_code() : string { return 'SRD'; }

  public function get_currency_code_numeric() : int { return 968; }

  public function get_currency_name() : string { return "Surinam Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_SRD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'SRD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'SRD'; }

  public function get_currency_code_numeric() : int { return 968; }

  public function get_currency_name() : string { return "Surinam Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_SSP extends MudCurrency {

  public function get_currency_code() : string { return 'SSP'; }

  public function get_currency_code_numeric() : int { return 728; }

  public function get_currency_name() : string { return "South Sudanese Pound"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_SSP extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'SSP' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'SSP'; }

  public function get_currency_code_numeric() : int { return 728; }

  public function get_currency_name() : string { return "South Sudanese Pound"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_STN extends MudCurrency {

  public function get_currency_code() : string { return 'STN'; }

  public function get_currency_code_numeric() : int { return 930; }

  public function get_currency_name() : string { return "Dobra"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_STN extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'STN' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'STN'; }

  public function get_currency_code_numeric() : int { return 930; }

  public function get_currency_name() : string { return "Dobra"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_SVC extends MudCurrency {

  public function get_currency_code() : string { return 'SVC'; }

  public function get_currency_code_numeric() : int { return 222; }

  public function get_currency_name() : string { return "El Salvador Colon"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_SVC extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'SVC' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'SVC'; }

  public function get_currency_code_numeric() : int { return 222; }

  public function get_currency_name() : string { return "El Salvador Colon"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_SYP extends MudCurrency {

  public function get_currency_code() : string { return 'SYP'; }

  public function get_currency_code_numeric() : int { return 760; }

  public function get_currency_name() : string { return "Syrian Pound"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_SYP extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'SYP' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'SYP'; }

  public function get_currency_code_numeric() : int { return 760; }

  public function get_currency_name() : string { return "Syrian Pound"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_SZL extends MudCurrency {

  public function get_currency_code() : string { return 'SZL'; }

  public function get_currency_code_numeric() : int { return 748; }

  public function get_currency_name() : string { return "Lilangeni"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_SZL extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'SZL' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'SZL'; }

  public function get_currency_code_numeric() : int { return 748; }

  public function get_currency_name() : string { return "Lilangeni"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_THB extends MudCurrency {

  public function get_currency_code() : string { return 'THB'; }

  public function get_currency_code_numeric() : int { return 764; }

  public function get_currency_name() : string { return "Baht"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_THB extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'THB' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'THB'; }

  public function get_currency_code_numeric() : int { return 764; }

  public function get_currency_name() : string { return "Baht"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_TJS extends MudCurrency {

  public function get_currency_code() : string { return 'TJS'; }

  public function get_currency_code_numeric() : int { return 972; }

  public function get_currency_name() : string { return "Somoni"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_TJS extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'TJS' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'TJS'; }

  public function get_currency_code_numeric() : int { return 972; }

  public function get_currency_name() : string { return "Somoni"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_TMT extends MudCurrency {

  public function get_currency_code() : string { return 'TMT'; }

  public function get_currency_code_numeric() : int { return 934; }

  public function get_currency_name() : string { return "Turkmenistan New Manat"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_TMT extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'TMT' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'TMT'; }

  public function get_currency_code_numeric() : int { return 934; }

  public function get_currency_name() : string { return "Turkmenistan New Manat"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_TND extends MudCurrency {

  public function get_currency_code() : string { return 'TND'; }

  public function get_currency_code_numeric() : int { return 788; }

  public function get_currency_name() : string { return "Tunisian Dinar"; }

  public function get_currency_minor_unit() : int { return 3; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_TND extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'TND' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'TND'; }

  public function get_currency_code_numeric() : int { return 788; }

  public function get_currency_name() : string { return "Tunisian Dinar"; }

  public function get_currency_minor_unit() : int { return 3; }

}


class MudCurrency_TOP extends MudCurrency {

  public function get_currency_code() : string { return 'TOP'; }

  public function get_currency_code_numeric() : int { return 776; }

  public function get_currency_name() : string { return "Pa\u2019anga"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_TOP extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'TOP' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'TOP'; }

  public function get_currency_code_numeric() : int { return 776; }

  public function get_currency_name() : string { return "Pa\u2019anga"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_TRY extends MudCurrency {

  public function get_currency_code() : string { return 'TRY'; }

  public function get_currency_code_numeric() : int { return 949; }

  public function get_currency_name() : string { return "Turkish Lira"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_TRY extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'TRY' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'TRY'; }

  public function get_currency_code_numeric() : int { return 949; }

  public function get_currency_name() : string { return "Turkish Lira"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_TTD extends MudCurrency {

  public function get_currency_code() : string { return 'TTD'; }

  public function get_currency_code_numeric() : int { return 780; }

  public function get_currency_name() : string { return "Trinidad and Tobago Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_TTD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'TTD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'TTD'; }

  public function get_currency_code_numeric() : int { return 780; }

  public function get_currency_name() : string { return "Trinidad and Tobago Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_TWD extends MudCurrency {

  public function get_currency_code() : string { return 'TWD'; }

  public function get_currency_code_numeric() : int { return 901; }

  public function get_currency_name() : string { return "New Taiwan Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_TWD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'TWD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'TWD'; }

  public function get_currency_code_numeric() : int { return 901; }

  public function get_currency_name() : string { return "New Taiwan Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_TZS extends MudCurrency {

  public function get_currency_code() : string { return 'TZS'; }

  public function get_currency_code_numeric() : int { return 834; }

  public function get_currency_name() : string { return "Tanzanian Shilling"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_TZS extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'TZS' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'TZS'; }

  public function get_currency_code_numeric() : int { return 834; }

  public function get_currency_name() : string { return "Tanzanian Shilling"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_UAH extends MudCurrency {

  public function get_currency_code() : string { return 'UAH'; }

  public function get_currency_code_numeric() : int { return 980; }

  public function get_currency_name() : string { return "Hryvnia"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_UAH extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'UAH' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'UAH'; }

  public function get_currency_code_numeric() : int { return 980; }

  public function get_currency_name() : string { return "Hryvnia"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_UGX extends MudCurrency {

  public function get_currency_code() : string { return 'UGX'; }

  public function get_currency_code_numeric() : int { return 800; }

  public function get_currency_name() : string { return "Uganda Shilling"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_UGX extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'UGX' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'UGX'; }

  public function get_currency_code_numeric() : int { return 800; }

  public function get_currency_name() : string { return "Uganda Shilling"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_USD extends MudCurrency {

  public function get_currency_code() : string { return 'USD'; }

  public function get_currency_code_numeric() : int { return 840; }

  public function get_currency_name() : string { return "US Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_USD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'USD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'USD'; }

  public function get_currency_code_numeric() : int { return 840; }

  public function get_currency_name() : string { return "US Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_USN extends MudCurrency {

  public function get_currency_code() : string { return 'USN'; }

  public function get_currency_code_numeric() : int { return 997; }

  public function get_currency_name() : string { return "US Dollar (Next day)"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_USN extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'USN' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'USN'; }

  public function get_currency_code_numeric() : int { return 997; }

  public function get_currency_name() : string { return "US Dollar (Next day)"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_UYI extends MudCurrency {

  public function get_currency_code() : string { return 'UYI'; }

  public function get_currency_code_numeric() : int { return 940; }

  public function get_currency_name() : string { return "Uruguay Peso en Unidades Indexadas (UI)"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_UYI extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'UYI' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'UYI'; }

  public function get_currency_code_numeric() : int { return 940; }

  public function get_currency_name() : string { return "Uruguay Peso en Unidades Indexadas (UI)"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_UYU extends MudCurrency {

  public function get_currency_code() : string { return 'UYU'; }

  public function get_currency_code_numeric() : int { return 858; }

  public function get_currency_name() : string { return "Peso Uruguayo"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_UYU extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'UYU' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'UYU'; }

  public function get_currency_code_numeric() : int { return 858; }

  public function get_currency_name() : string { return "Peso Uruguayo"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_UYW extends MudCurrency {

  public function get_currency_code() : string { return 'UYW'; }

  public function get_currency_code_numeric() : int { return 927; }

  public function get_currency_name() : string { return "Unidad Previsional"; }

  public function get_currency_minor_unit() : int { return 4; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_UYW extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'UYW' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'UYW'; }

  public function get_currency_code_numeric() : int { return 927; }

  public function get_currency_name() : string { return "Unidad Previsional"; }

  public function get_currency_minor_unit() : int { return 4; }

}


class MudCurrency_UZS extends MudCurrency {

  public function get_currency_code() : string { return 'UZS'; }

  public function get_currency_code_numeric() : int { return 860; }

  public function get_currency_name() : string { return "Uzbekistan Sum"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_UZS extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'UZS' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'UZS'; }

  public function get_currency_code_numeric() : int { return 860; }

  public function get_currency_name() : string { return "Uzbekistan Sum"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_VED extends MudCurrency {

  public function get_currency_code() : string { return 'VED'; }

  public function get_currency_code_numeric() : int { return 926; }

  public function get_currency_name() : string { return "Bol\u00edvar Soberano"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_VED extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'VED' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'VED'; }

  public function get_currency_code_numeric() : int { return 926; }

  public function get_currency_name() : string { return "Bol\u00edvar Soberano"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_VES extends MudCurrency {

  public function get_currency_code() : string { return 'VES'; }

  public function get_currency_code_numeric() : int { return 928; }

  public function get_currency_name() : string { return "Bol\u00edvar Soberano"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_VES extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'VES' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'VES'; }

  public function get_currency_code_numeric() : int { return 928; }

  public function get_currency_name() : string { return "Bol\u00edvar Soberano"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_VND extends MudCurrency {

  public function get_currency_code() : string { return 'VND'; }

  public function get_currency_code_numeric() : int { return 704; }

  public function get_currency_name() : string { return "Dong"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_VND extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'VND' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'VND'; }

  public function get_currency_code_numeric() : int { return 704; }

  public function get_currency_name() : string { return "Dong"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_VUV extends MudCurrency {

  public function get_currency_code() : string { return 'VUV'; }

  public function get_currency_code_numeric() : int { return 548; }

  public function get_currency_name() : string { return "Vatu"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_VUV extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'VUV' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'VUV'; }

  public function get_currency_code_numeric() : int { return 548; }

  public function get_currency_name() : string { return "Vatu"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_WST extends MudCurrency {

  public function get_currency_code() : string { return 'WST'; }

  public function get_currency_code_numeric() : int { return 882; }

  public function get_currency_name() : string { return "Tala"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_WST extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'WST' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'WST'; }

  public function get_currency_code_numeric() : int { return 882; }

  public function get_currency_name() : string { return "Tala"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_XAF extends MudCurrency {

  public function get_currency_code() : string { return 'XAF'; }

  public function get_currency_code_numeric() : int { return 950; }

  public function get_currency_name() : string { return "CFA Franc BEAC"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XAF extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XAF' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XAF'; }

  public function get_currency_code_numeric() : int { return 950; }

  public function get_currency_name() : string { return "CFA Franc BEAC"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_XAG extends MudCurrency {

  public function get_currency_code() : string { return 'XAG'; }

  public function get_currency_code_numeric() : int { return 961; }

  public function get_currency_name() : string { return "Silver"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XAG extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XAG' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XAG'; }

  public function get_currency_code_numeric() : int { return 961; }

  public function get_currency_name() : string { return "Silver"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_XAU extends MudCurrency {

  public function get_currency_code() : string { return 'XAU'; }

  public function get_currency_code_numeric() : int { return 959; }

  public function get_currency_name() : string { return "Gold"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XAU extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XAU' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XAU'; }

  public function get_currency_code_numeric() : int { return 959; }

  public function get_currency_name() : string { return "Gold"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_XBA extends MudCurrency {

  public function get_currency_code() : string { return 'XBA'; }

  public function get_currency_code_numeric() : int { return 955; }

  public function get_currency_name() : string { return "Bond Markets Unit European Composite Unit (EURCO)"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XBA extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XBA' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XBA'; }

  public function get_currency_code_numeric() : int { return 955; }

  public function get_currency_name() : string { return "Bond Markets Unit European Composite Unit (EURCO)"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_XBB extends MudCurrency {

  public function get_currency_code() : string { return 'XBB'; }

  public function get_currency_code_numeric() : int { return 956; }

  public function get_currency_name() : string { return "Bond Markets Unit European Monetary Unit (E.M.U.-6)"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XBB extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XBB' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XBB'; }

  public function get_currency_code_numeric() : int { return 956; }

  public function get_currency_name() : string { return "Bond Markets Unit European Monetary Unit (E.M.U.-6)"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_XBC extends MudCurrency {

  public function get_currency_code() : string { return 'XBC'; }

  public function get_currency_code_numeric() : int { return 957; }

  public function get_currency_name() : string { return "Bond Markets Unit European Unit of Account 9 (E.U.A.-9)"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XBC extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XBC' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XBC'; }

  public function get_currency_code_numeric() : int { return 957; }

  public function get_currency_name() : string { return "Bond Markets Unit European Unit of Account 9 (E.U.A.-9)"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_XBD extends MudCurrency {

  public function get_currency_code() : string { return 'XBD'; }

  public function get_currency_code_numeric() : int { return 958; }

  public function get_currency_name() : string { return "Bond Markets Unit European Unit of Account 17 (E.U.A.-17)"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XBD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XBD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XBD'; }

  public function get_currency_code_numeric() : int { return 958; }

  public function get_currency_name() : string { return "Bond Markets Unit European Unit of Account 17 (E.U.A.-17)"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_XCD extends MudCurrency {

  public function get_currency_code() : string { return 'XCD'; }

  public function get_currency_code_numeric() : int { return 951; }

  public function get_currency_name() : string { return "East Caribbean Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XCD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XCD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XCD'; }

  public function get_currency_code_numeric() : int { return 951; }

  public function get_currency_name() : string { return "East Caribbean Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_XDR extends MudCurrency {

  public function get_currency_code() : string { return 'XDR'; }

  public function get_currency_code_numeric() : int { return 960; }

  public function get_currency_name() : string { return "SDR (Special Drawing Right)"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XDR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XDR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XDR'; }

  public function get_currency_code_numeric() : int { return 960; }

  public function get_currency_name() : string { return "SDR (Special Drawing Right)"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_XOF extends MudCurrency {

  public function get_currency_code() : string { return 'XOF'; }

  public function get_currency_code_numeric() : int { return 952; }

  public function get_currency_name() : string { return "CFA Franc BCEAO"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XOF extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XOF' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XOF'; }

  public function get_currency_code_numeric() : int { return 952; }

  public function get_currency_name() : string { return "CFA Franc BCEAO"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_XPD extends MudCurrency {

  public function get_currency_code() : string { return 'XPD'; }

  public function get_currency_code_numeric() : int { return 964; }

  public function get_currency_name() : string { return "Palladium"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XPD extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XPD' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XPD'; }

  public function get_currency_code_numeric() : int { return 964; }

  public function get_currency_name() : string { return "Palladium"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_XPF extends MudCurrency {

  public function get_currency_code() : string { return 'XPF'; }

  public function get_currency_code_numeric() : int { return 953; }

  public function get_currency_name() : string { return "CFP Franc"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XPF extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XPF' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XPF'; }

  public function get_currency_code_numeric() : int { return 953; }

  public function get_currency_name() : string { return "CFP Franc"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_XPT extends MudCurrency {

  public function get_currency_code() : string { return 'XPT'; }

  public function get_currency_code_numeric() : int { return 962; }

  public function get_currency_name() : string { return "Platinum"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XPT extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XPT' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XPT'; }

  public function get_currency_code_numeric() : int { return 962; }

  public function get_currency_name() : string { return "Platinum"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_XSU extends MudCurrency {

  public function get_currency_code() : string { return 'XSU'; }

  public function get_currency_code_numeric() : int { return 994; }

  public function get_currency_name() : string { return "Sucre"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XSU extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XSU' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XSU'; }

  public function get_currency_code_numeric() : int { return 994; }

  public function get_currency_name() : string { return "Sucre"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_XTS extends MudCurrency {

  public function get_currency_code() : string { return 'XTS'; }

  public function get_currency_code_numeric() : int { return 963; }

  public function get_currency_name() : string { return "Codes specifically reserved for testing purposes"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XTS extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XTS' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XTS'; }

  public function get_currency_code_numeric() : int { return 963; }

  public function get_currency_name() : string { return "Codes specifically reserved for testing purposes"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_XUA extends MudCurrency {

  public function get_currency_code() : string { return 'XUA'; }

  public function get_currency_code_numeric() : int { return 965; }

  public function get_currency_name() : string { return "ADB Unit of Account"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XUA extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XUA' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XUA'; }

  public function get_currency_code_numeric() : int { return 965; }

  public function get_currency_name() : string { return "ADB Unit of Account"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_XXX extends MudCurrency {

  public function get_currency_code() : string { return 'XXX'; }

  public function get_currency_code_numeric() : int { return 999; }

  public function get_currency_name() : string { return "The codes assigned for transactions where no currency is involved"; }

  public function get_currency_minor_unit() : int { return 0; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_XXX extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'XXX' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'XXX'; }

  public function get_currency_code_numeric() : int { return 999; }

  public function get_currency_name() : string { return "The codes assigned for transactions where no currency is involved"; }

  public function get_currency_minor_unit() : int { return 0; }

}


class MudCurrency_YER extends MudCurrency {

  public function get_currency_code() : string { return 'YER'; }

  public function get_currency_code_numeric() : int { return 886; }

  public function get_currency_name() : string { return "Yemeni Rial"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_YER extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'YER' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'YER'; }

  public function get_currency_code_numeric() : int { return 886; }

  public function get_currency_name() : string { return "Yemeni Rial"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_ZAR extends MudCurrency {

  public function get_currency_code() : string { return 'ZAR'; }

  public function get_currency_code_numeric() : int { return 710; }

  public function get_currency_name() : string { return "Rand"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_ZAR extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'ZAR' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'ZAR'; }

  public function get_currency_code_numeric() : int { return 710; }

  public function get_currency_name() : string { return "Rand"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_ZMW extends MudCurrency {

  public function get_currency_code() : string { return 'ZMW'; }

  public function get_currency_code_numeric() : int { return 967; }

  public function get_currency_name() : string { return "Zambian Kwacha"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_ZMW extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'ZMW' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'ZMW'; }

  public function get_currency_code_numeric() : int { return 967; }

  public function get_currency_name() : string { return "Zambian Kwacha"; }

  public function get_currency_minor_unit() : int { return 2; }

}


class MudCurrency_ZWL extends MudCurrency {

  public function get_currency_code() : string { return 'ZWL'; }

  public function get_currency_code_numeric() : int { return 932; }

  public function get_currency_name() : string { return "Zimbabwe Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}


class MudMoney_ZWL extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( 'ZWL' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return 'ZWL'; }

  public function get_currency_code_numeric() : int { return 932; }

  public function get_currency_name() : string { return "Zimbabwe Dollar"; }

  public function get_currency_minor_unit() : int { return 2; }

}

