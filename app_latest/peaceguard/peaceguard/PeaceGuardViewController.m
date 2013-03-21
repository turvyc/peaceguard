//
//  PeaceGuardViewController.m
//
//  Contributor(s): Ashley Lesperance
//
//  Copyright (c) 2013 Number 123 Developer's Group
//


#import "PeaceGuardViewController.h"
#import "User.h"
#import "UserDataController.h"

#import "MainViewController.h"

@interface PeaceGuardViewController (){
    CLGeocoder *geocoder;
    CLPlacemark *placemark;
}

@end

@implementation PeaceGuardViewController


- (void)touchesBegan:(NSSet *)touches withEvent:(UIEvent *)event
{
    [self.view endEditing:YES];
}

- (BOOL) textFieldShouldReturn:(UITextField *)textField {
    [textField resignFirstResponder];
    return YES;
}


- (IBAction)Login:(id)sender {
    //BOOL authentication = [self logUsername:self.username.text password:self.password.text];
    //self.usernameData = self.username.text;
    self.user = [[User alloc] initWithUsername:self.username.text password:self.password.text];
    self.connectionManager = [[ConnectionDataController alloc] init];
    BOOL authentication = [self.connectionManager serverLoginWithEmail:self.username.text andPassword:self.password.text];
    //self.username.text = @"";
    self.password.text = @"";
    
    if( authentication == YES) {
        //the login is correct
        [self performSegueWithIdentifier:@"ToMainMenu" sender:self];
    }else{
        //Let the user know the login failed
        UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Login Failed"
                                                        message:@"The username or password was incorrect."
                                                       delegate:nil
                                              cancelButtonTitle:@"OK"
                                              otherButtonTitles:nil];
        [alert show];
    }
}



- (void)viewDidLoad
{
    [super viewDidLoad];
    NSURL*url=[NSURL URLWithString:@"https://vancouver.ca/police/"];
    NSURLRequest*request=[NSURLRequest requestWithURL:url];
    [_help loadRequest:request];
    _locationManager = [[CLLocationManager alloc] init];
    [_locationManager startUpdatingLocation];
    geocoder = [[CLGeocoder alloc] init];
	// Do any additional setup after loading the view, typically from a nib.
    [self deviceLocation];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)deviceLocation {
    NSString *Address;
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

-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender{
        MainViewController *mainContoller = (MainViewController *)segue.destinationViewController;
        mainContoller.usernameData = self.username.text;

}


@end
