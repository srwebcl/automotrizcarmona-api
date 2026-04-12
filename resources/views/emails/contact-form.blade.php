<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nuevo Contacto</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f6f8; padding: 20px;">

    <div style="max-w: 600px; background-color: #ffffff; margin: 0 auto; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <h2 style="color: #d2001c; margin-top: 0;">Nuevo mensaje desde sitio web</h2>
        
        <p style="color: #555555; text-transform: uppercase; font-size: 12px; font-weight: bold; margin-bottom: 5px;">Origen del formulario</p>
        <p style="margin-top: 0; font-size: 16px; font-weight: bold; color: #333333;">{{ strtoupper($lead->source) }}</p>

        <hr style="border: none; border-top: 1px solid #eeeeee; margin: 20px 0;">

        <h3 style="color: #333333; margin-bottom: 10px;">Datos del Cliente</h3>
        <table style="width: 100%; border-collapse: collapse;">
            @if($lead->rut)
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #777; width: 120px;">RUT</td>
                <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #333; font-weight: bold;">{{ $lead->rut }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #777; width: 120px;">Nombre</td>
                <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #333; font-weight: bold;">{{ $lead->name }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #777;">Email</td>
                <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #333; font-weight: bold;"><a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a></td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #777;">Teléfono</td>
                <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #333; font-weight: bold;"><a href="tel:{{ $lead->phone }}">{{ $lead->phone }}</a></td>
            </tr>
            @if($lead->raw_request && isset($lead->raw_request['vehicle']))
                @php $veh = $lead->raw_request['vehicle']; @endphp
                @if(isset($veh['brand_name']))
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #777;">Vehículo (Marca)</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #333; font-weight: bold;">{{ $veh['brand_name'] }}</td>
                    </tr>
                @endif
                @if(isset($veh['model_name']))
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #777;">Vehículo (Modelo)</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #333; font-weight: bold;">{{ $veh['model_name'] }}</td>
                    </tr>
                @endif
                @if(isset($veh['year']))
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #777;">Año</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #333; font-weight: bold;">{{ $veh['year'] }}</td>
                    </tr>
                @endif
                @if(isset($veh['vin']))
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #777;">VIN / Patente</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f8f9fa; color: #333; font-weight: bold;">{{ $veh['vin'] }}</td>
                    </tr>
                @endif
            @endif
        </table>

        <h3 style="color: #333333; margin-top: 25px; margin-bottom: 10px;">Mensaje / Solicitud</h3>
        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 6px; color: #333; white-space: pre-wrap; line-height: 1.5;">{{ $lead->message ?? 'Sin mensaje / detalles' }}</div>

        <p style="margin-top: 30px; font-size: 12px; color: #999; text-align: center;">
            Este es un correo automático generado desde el sitio web de Automotriz Carmona.
        </p>
    </div>

</body>
</html>
