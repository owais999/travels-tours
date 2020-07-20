<div class="form-group">
    <i class="field-icon fa icofont-air-ticket"></i>
    <div class="form-content">
        <label>{{ $field['title'] ?? "" }}</label>
        <div class="smart-search">
            <select class="form-control" id="select-country" data-live-search="true">
                <option data-tokens="economy">ECONOMY</option>
                <option data-tokens="business">BUSINESS</option>
                <option data-tokens="premium economy">PREMIUM ECONOMY</option>
                <option data-tokens="first">FIRSTY</option>i
                <option data-tokens="multiple">MULTIPLE</option>
            </select>
        </div>
    </div>
</div>