function goto(intIn, index)
{
    if(intIn == 0)
    {
        document.forms["stratSettingsForm" + index].submit();
    }
    else if(intIn == 1)
    {
        document.forms["stratDeleteForm" + index].submit();
    }
}