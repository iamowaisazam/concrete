<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDevice;

class DeviceController extends Controller
{
private function getClientIp()
    {
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($ipList[0]);
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        }
        return 'UNKNOWN';
    }

    private function getDeviceType($userAgent)
    {
        if (preg_match('/Mobile|Tablet|iPad|iPhone|Android/i', $userAgent)) {
            return 'Mobile';
        } elseif (preg_match('/Windows|Macintosh|Linux/i', $userAgent)) {
            return 'Desktop';
        }
        return 'Unknown';
    }

    private function getPlatform($userAgent)
    {
        if (preg_match('/Windows/i', $userAgent)) return 'Windows';
        if (preg_match('/Macintosh/i', $userAgent)) return 'Macintosh';
        if (preg_match('/Linux/i', $userAgent)) return 'Linux';
        if (preg_match('/Android/i', $userAgent)) return 'Android';
        if (preg_match('/iPhone/i', $userAgent)) return 'iPhone';
        return 'Unknown';
    }

    private function getBrowser($userAgent)
    {
        if (preg_match('/MSIE|Trident/i', $userAgent)) return 'Internet Explorer';
        if (preg_match('/Firefox/i', $userAgent)) return 'Firefox';
        if (preg_match('/Chrome/i', $userAgent)) return 'Chrome';
        if (preg_match('/Safari/i', $userAgent)) return 'Safari';
        if (preg_match('/Opera|OPR/i', $userAgent)) return 'Opera';
        return 'Unknown';
    }

    private function getLocationByIp($ip)
    {
        $default = [
            'country' => null,
            'countryCode' => null,
            'region' => null,
            'regionName' => null,
            'city' => null,
            'zip' => null,
            'lat' => null,
            'lon' => null,
            'timezone' => null,
            'isp' => null,
            'org' => null,
            'as' => null,
            'query' => $ip,
            'location' => 'Not found',
        ];

        try {
            $response = @file_get_contents("http://ip-api.com/json/{$ip}");
            $data = json_decode($response, true);

            if ($data && $data['status'] === 'success') {
                $data['location'] = $data['city'] . ', ' . $data['regionName'] . ', ' . $data['country'];
                return array_merge($default, $data);
            }
        } catch (\Exception $e) {
            // fallback
        }

        return $default;
    }

    public function storeDeviceInfo(Request $request)
    {
        $userId    = auth()->id();
        $userAgent = $request->server('HTTP_USER_AGENT', 'Unknown');
        $ip        = $this->getClientIp();

        $device    = $this->getDeviceType($userAgent);
        $platform  = $this->getPlatform($userAgent);
        $browser   = $this->getBrowser($userAgent);

        $locationData = $this->getLocationByIp($ip);

        $existing = UserDevice::where('user_id', $userId)
            ->where('ip_address', $ip)
            ->where('device', $device)
            ->where('platform', $platform)
            ->where('browser', $browser)
            ->where('user_agent', $userAgent)
            ->first();

        if ($existing) {
            $existing->delete();
        }

        UserDevice::create([
            'user_id'      => $userId,
            'ip_address'   => $ip,
            'device'       => $device,
            'platform'     => $platform,
            'browser'      => $browser,
            'user_agent'   => $userAgent,
            'location'     => $locationData['location'],
            'country'      => $locationData['country'],
            'country_code' => $locationData['countryCode'],
            'region'       => $locationData['region'],
            'region_name'  => $locationData['regionName'],
            'city'         => $locationData['city'],
            'zip'          => $locationData['zip'],
            'lat'          => $locationData['lat'],
            'lon'          => $locationData['lon'],
            'timezone'     => $locationData['timezone'],
            'isp'          => $locationData['isp'],
            'org'          => $locationData['org'],
            'as_info'      => $locationData['as'],
            'logged_in_at' => now(),
        ]);
    }
}



?>