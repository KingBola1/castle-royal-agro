<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

class TwoFactorAuthController extends Controller
{
    public function enable(Request $request)
    {
        $user = auth()->user();
        $google2fa = new Google2FA();
        
        // Generate secret key if not already present
        if (!$user->google2fa_secret) {
            $user->google2fa_secret = $google2fa->generateSecretKey();
            $user->save(); // Save immediately to lock it in
        }

        // Generate QR Code SVG
        $g2faUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );

        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeSvg = $writer->writeString($g2faUrl);

        return view('admin.2fa.setup', [
            'secret' => $user->google2fa_secret,
            'qrCodeSvg' => $qrCodeSvg
        ]);
    }

    public function showVerify()
    {
        return view('admin.2fa.verify');
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);
        $user = auth()->user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->code);

        if ($valid) {
            session(['2fa_verified' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['code' => 'Invalid authentication code.']);
    }

    public function disable(Request $request)
    {
        $user = auth()->user();
        $user->google2fa_secret = null;
        $user->save();

        return redirect()->back()->with('status', 'Two-Factor Authentication has been disabled.');
    }
}
