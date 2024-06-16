<?php

namespace App\Services\Report\Sale;

class individualReportService
{
    public static function individualReport($request, $query): array
    {
        $filter = $request->select_status['value'];
        $sale_details = collect($query['total_pieces'])->merge($query['sale_return']);
        if ($filter != 'pending') {
            $sale_details = collect($sale_details)->merge($query['sale_pending']);
        }
        $sale_details = collect($sale_details)->merge($query['sale_cancelled']);


        $columns = self::individualColumn();
        if (isset($request->selectedAmountType['value']) && $request->selectedAmountType['value'] !='delivery_amount') {
            $columns = collect($columns)->push([
                'title' => $request->selectedAmountType['text'],
                'key' => $request->selectedAmountType['value'],
                'class' => 'text-right',
            ]);
        } else {
            $columns = collect($columns)->concat(collect(SalesReport::amountType())->whereNotIn('text', ['Select Amount','Delivery Amount'])->map(function ($data) {
                return [
                    'title' => $data['text'],
                    'key' => $data['value'],
                    'class' => 'text-right',
                ];
            }));
        }
        $column_row_data = [];
        foreach ($sale_details->chunk(500) as $chunk) {
            foreach ($chunk as $index => $sale_detail) {
                $column_row_data[] = self::addingIndividualRow($columns, $index, $sale_detail);
            }
        }

        return [
            'columns' => $columns,
            'column_row_data' => $column_row_data,
        ];

    }

    public static function addingIndividualRow($columns, $index, $product): array
    {
        $data = [];
        foreach ($columns as $value) {
            $data[$value['key']] = self::indIndividualRowValue($value['key'], $index, $product);
        }
        return $data;
    }

    public static function indIndividualRowValue($key, $index, $sale_detail)
    {
        $data = [
            'sl_no' => $index + 1,
            'product_name' => self::productName($sale_detail),
            'suppliers' => $sale_detail->product->supplier->name ?? '',
            'categories' => $sale_detail->product->category->name ?? '',
            'brands' => $sale_detail->product->brand->name ?? '',
            'sell_quantity' => number_format($sale_detail->quantity),
            'status' => self::productStatus($sale_detail),
            'total_amount' => self::totalAmount($sale_detail),
            'profit_amount' => self::profitAmount($sale_detail),
            'purchase_amount' => self::purchaseAmount($sale_detail),
            'delivery_amount' => self::deliveryAmount($sale_detail),
            'discount_amount' => self::discountAmount($sale_detail),
            'vat_amount' => self::vatAmount($sale_detail),
        ];
        return $data[$key];
    }

    public static function totalAmount($sale_detail): string
    {
        if ($sale_detail->sale['cancelled'] > 0 || $sale_detail->returned > 0) {
            return '-' . formatWithComma($sale_detail->net_total) . get_settings('currency_symbol');
        } else {
            return formatWithComma($sale_detail->net_total) . get_settings('currency_symbol');
        }
    }

    public static function profitAmount($sale_detail): string
    {
        if ($sale_detail->sale['cancelled'] > 0 || $sale_detail->returned > 0) {
            return '';
        } else {
            return formatWithComma($sale_detail->product_total - ($sale_detail->buy_rate * $sale_detail->quantity)) . get_settings('currency_symbol');
        }
    }

    public static function purchaseAmount($sale_detail): string
    {
        if ($sale_detail->sale['cancelled'] > 0 || $sale_detail->returned > 0) {
            return formatWithComma($sale_detail->total_buy_price) . get_settings('currency_symbol');
        } else {
            return formatWithComma($sale_detail->total_buy_price) . get_settings('currency_symbol');
        }
    }

    public static function deliveryAmount($sale_detail): string
    {
        if ($sale_detail->sale['cancelled'] > 0 || $sale_detail->returned > 0) {
            return '';
        } else {
            return formatWithComma($sale_detail->delivery_amount) . get_settings('currency_symbol');
        }
    }

    public static function discountAmount($sale_detail): string
    {
        if ($sale_detail->sale['cancelled'] > 0 || $sale_detail->returned > 0) {
            return '';
        } else {
            return formatWithComma($sale_detail->discount_total + $sale_detail->flat_discount_total) . get_settings('currency_symbol');
        }
    }

    public static function vatAmount($sale_detail): string
    {
        if ($sale_detail->sale['cancelled'] > 0 || $sale_detail->returned > 0) {
            return '';
        } else {
            return formatWithComma($sale_detail->vat_total) . get_settings('currency_symbol');
        }
    }


    public static function productStatus($sale_detail)
    {
//        dd(collect($sale_detail)->toArray());
        if ($sale_detail->sale['delivered'] > 0) {
            return 'Delivered';
        } else if ($sale_detail->sale['cancelled'] > 0) {
            return 'Cancelled';
        } else if ($sale_detail->returned > 0) {
            return 'Returned';
        } else if ( $sale_detail->sale['pending'] || $sale_detail->total_pending > 0) {
            return 'Pending';
        } else if ($sale_detail->sale['with_out_delivery_sale'] > 0) {
            return 'Sale';
        }
    }

    public static function productName($sale_detail)
    {
        $product_name = $sale_detail->product->name;
        if (isset($sale_detail->productVariations)) {
            $product_name = $sale_detail->product->name . '-' . collect($sale_detail->productVariations->variantValues)
                    ->pluck('variantValueName.variation_value')
                    ->implode('-');
        }
        return $product_name;
    }

    public static function individualColumn(): array
    {
        return [
            [
                'title' => 'S.No.',
                'key' => 'sl_no',
                'class' => 'text-center',
            ],
            [
                'title' => 'Product Name',
                'key' => 'product_name',
                'class' => 'text-left',
            ],
            [
                'title' => 'Suppliers',
                'key' => 'suppliers',
                'class' => 'text-center',
            ],
            [
                'title' => 'Categories',
                'key' => 'categories',
                'class' => 'text-center',
            ],
            [
                'title' => 'Brands',
                'key' => 'brands',
                'class' => 'text-center',
            ],
            [
                'title' => 'Sell Quantity',
                'key' => 'sell_quantity',
                'class' => 'text-center',
            ],
            [
                'title' => 'Status',
                'key' => 'status',
                'class' => 'text-center',
            ],
        ];
    }

}
