from flask import Flask, jsonify
from flask_cors import CORS
from math import ceil
app = Flask(__name__)
CORS(app)

# Define the cost calculation logic
def calculate_shipping_cost(mode, value):
    if mode == "weight":
        if value <= 0:
            return "rejected", "Invalid weight"
        if value > 70:
            return "rejected", "Maximum weight per package is 70kg"
        if value <= 1:
            cost = 300  # Initial cost for first 1 kg
        else:
            cost = 300 + 50 * ceil(value - 1)  # $50 for each additional kg after the first
    elif mode == "quantity":
        if value <= 0:
            return "rejected", "Invalid quantity"
        if value > 30:
            return "rejected", "Maximum number of units per package is 30"
        if value == 1:
            cost = 300  # Initial cost for first unit
        else:
            cost = 300 + 60 * ceil(value - 1)  # $60 for each additional unit after the first
    else:
        return "rejected", "Error : mode must be 'quantity' or 'weight'"

    return "accepted", int(cost)

@app.route('/ship_cost_api/<mode>/<value>', methods=['GET'])
def ship_cost_api(mode, value):
    try:
        value = float(value)
    except ValueError:
        return jsonify({
            "result": "rejected",
            "reason": "Invalid value"
        }), 400

    result, info = calculate_shipping_cost(mode, value)
    
    if result == "accepted":
        return jsonify({
            "result": "accepted",
            "cost": info
        })
    else:
        return jsonify({
            "result": "rejected",
            "reason": info
        })

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=8080)