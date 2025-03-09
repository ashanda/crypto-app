<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

class GoogleAuthenticatorController extends Controller
{
    public function setupGoogleAuthenticator($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return back()->with('error', 'User not found');
        }

        $gAuth = new GoogleAuthenticator();

        // Generate a secret key for the user
        $secret = $gAuth->generateSecret();

        // Store the secret key in the user's database
        $user->google_authenticator_secret = $secret;
        $user->save();

        // Generate the QR code URL (Google Authenticator format)
        $appName = 'YourAppName'; // Change this to your app's name
        $qrCodeUrl = 'otpauth://totp/' . urlencode("$appName:{$user->email}") .
                     '?secret=' . $secret . '&issuer=' . urlencode($appName);

        // Generate QR code using BaconQrCode (WITHOUT Imagick)
        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd() // Using SVG instead of Imagick
        );

        $writer = new Writer($renderer);
        $qrCodeImage = base64_encode($writer->writeString($qrCodeUrl));

        // Convert QR code image to Base64 for embedding in the view
        $qrCodeImageBase64 = 'data:image/svg+xml;base64,' . $qrCodeImage;

        // Pass QR code and secret key to the view
        return view('admin.setup_google_authenticator', compact('qrCodeImageBase64', 'secret'));
    }
}
