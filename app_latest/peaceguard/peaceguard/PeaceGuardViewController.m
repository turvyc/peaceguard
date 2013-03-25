//
//  PeaceGuardViewController.m
//
//  Contributor(s): Ashley Lesperance
//
//  Copyright (c) 2013 Number 123 Developer's Group
//


#import "PeaceGuardViewController.h"


@interface PeaceGuardViewController (){
    CLGeocoder *geocoder;
    CLPlacemark *placemark;
}

@end

@implementation PeaceGuardViewController


- (void)touchesBegan:(NSSet *)touches withEvent:(UIEvent *)event
{
    //put the screen back in its original location
    [self.view endEditing:YES];
    [UIView beginAnimations:nil context:NULL];
    [UIView setAnimationDuration:0.25];
    self.view.center = CGPointMake(self.originalCenter.x, self.originalCenter.y-44);
    [UIView commitAnimations];
}

- (BOOL)textFieldShouldReturn:(UITextField *)textField {
    //put the screen back in its original location
    [textField resignFirstResponder];
    [UIView beginAnimations:nil context:NULL];
    [UIView setAnimationDuration:0.25];
    self.view.center = CGPointMake(self.originalCenter.x, self.originalCenter.y-44);
    [UIView commitAnimations];
    return YES;
}


- (void)keyboardDidShow:(NSNotification *)note
{
    //Move to the screen up to not block the login text fields
    [UIView beginAnimations:nil context:NULL];
    [UIView setAnimationDuration:0.25];
    self.view.center = CGPointMake(self.originalCenter.x, 10);
    [UIView commitAnimations];
}

- (void)keyboardDidHide:(NSNotification *)note
{
    //put the screen back in its original location
    [UIView beginAnimations:nil context:NULL];
    [UIView setAnimationDuration:0.25];
    self.view.center = CGPointMake(self.originalCenter.x, self.originalCenter.y-44);
    [UIView commitAnimations];
}

- (IBAction)Login:(id)sender {
    //Allocate user based on username and password provided and server connections
    self.user = [[User alloc] initWithUsername:self.username.text password:self.password.text];
    self.connectionManager = [[ConnectionDataController alloc] init];
    //Check if username and password is valid on server
    BOOL authentication = [self.connectionManager serverLoginWithEmail:self.username.text andPassword:self.password.text];
    //Clear password from text field
    self.password.text = @"";
    //If the username and password is valid, set as default and allow user to login
    if( authentication == YES) {
        //the login is correct
        NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
        [defaults setObject:self.username.text forKey:@"username"];
        [defaults synchronize];
        [self performSegueWithIdentifier:@"ToMainMenu" sender:self];
    }
}



- (void)viewDidLoad
{
    [super viewDidLoad];
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(keyboardDidShow:) name:UIKeyboardDidShowNotification object:nil]; 
    self.originalCenter = self.view.center;
    NSURL*url=[NSURL URLWithString:@"http://www.sfu.ca/~zhongl/cmpt275/cmpt275tutorial.html"];
    NSURLRequest*request=[NSURLRequest requestWithURL:url];
    [_help loadRequest:request];
    _locationManager = [[CLLocationManager alloc] init];
    [_locationManager startUpdatingLocation];
    geocoder = [[CLGeocoder alloc] init];
    [self deviceLocation];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

//Get the current location and set it as a global variable for later use
- (void)deviceLocation {
    [geocoder reverseGeocodeLocation:_locationManager.location completionHandler:^(NSArray *placemarks, NSError *error) {
        if (error == nil && [placemarks count] > 0){
            placemark = [placemarks lastObject];
            NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
            NSString *current_location = [NSString stringWithFormat:@"%@ %@\n%@ %@\n%@\n%@",
                                          placemark.subThoroughfare, placemark.thoroughfare,
                                          placemark.postalCode, placemark.locality,
                                          placemark.administrativeArea,
                                          placemark.country];
            [defaults setObject:current_location forKey:@"currentLocation"];
            [defaults synchronize];
        } else{
            NSLog(@"%@", error.debugDescription);
        }
    }
    ];
}


@end
