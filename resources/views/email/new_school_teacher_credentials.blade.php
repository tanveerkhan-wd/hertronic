
<table align="center" background="" border="0" cellpadding="0" cellspacing="0" class="wrap wrapbg" style="border-collapse: collapse; width: 640px; margin: 0px auto; background-image: none; background-color: #ffffff;" width="640">
    <tr>
        <td align="center" class="module-td3" style="padding: 40px 0 10px;"><table align="center" border="0" cellpadding="0" cellspacing="0" class="row" style="border-collapse: collapse;" width="640">
                <tr>
                    <td align="left" class="content"  style="font-family: Open Sans,Arial;color: #7a839a;font-size: 14px;line-height: 22px;font-weight: 400;-webkit-font-smoothing: antialiased;"><h4 class="h4 hlight" style="font-family: Raleway, Tahoma; color: #00d5c3; font-weight: 400; font-size: 24px; line-height: 28px; margin: 0px 0px 8px !important; text-align: left;"> <span style="color:#000000; text-transform: capitalize;">Hello {NAME}, </span></h4>
                        <p style="font-family: 'Open Sans', Arial; color: #000; font-size: 12px; line-height: 22px; font-weight: 400; -webkit-font-smoothing: antialiased; margin: 0px 0px 8px !important; text-align: left;"> <span style="color:#000000;">You have been assigned as Teacher at '{SCHOOLNAME}'. Here are your login credentials, please verify your email & reset your password for login at <a target="_blank" href="{{url('/')}}">Hertronic</a></span></p>
                        <p style="font-family: 'Open Sans', Arial; color: #7a839a; font-size: 14px; line-height: 22px; font-weight: 400; -webkit-font-smoothing: antialiased; margin: 0px 0px 8px !important; text-align: left;"> <span style="color:#000000;">Email : <strong> {EMAIL}</strong> </span></p>
                        <p style="font-family: 'Open Sans', Arial; color: #000; font-size: 12px; line-height: 22px; font-weight: 400; -webkit-font-smoothing: antialiased; margin: 0px 0px 8px !important; text-align: left;"><a href="{!! URL::to('resetPassword') !!}/{RESET_PASS_LINK}" target="_blank">Click here to reset your password.</a></p>
                        <p style="font-family: 'Open Sans', Arial; color: #000; font-size: 12px; line-height: 22px; font-weight: 400; -webkit-font-smoothing: antialiased; margin: 0px 0px 8px !important; text-align: left;"><a href="{!! URL::to('verifyEmail') !!}?verification-key={VERIFY_KEY}" target="_blank">Click here to verify your email.</a></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
