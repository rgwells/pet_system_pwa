

function diceRoll (sides, count)
{
    let result = 0;
    for (let i = 0; i < count; i++)
    {
        result += Math.floor (Math.random() * (sides - 1));
    }
    return (result);
}


